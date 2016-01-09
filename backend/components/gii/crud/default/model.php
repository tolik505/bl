<?php
/**
 * This is the template for generating the model class of a specified table.
 */
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator \backend\components\gii\crud\Generator */
/* @var $viewColumns array */
/* @var $indexColumns */
/* @var $formColumns */

$modelClass = StringHelper::basename($generator->modelClass);

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->modelClass, '\\')) ?>;

use backend\components\BackendModel;
use metalguardian\formBuilder\ActiveFormBuilder;
<?php if ($generator->isImage) { ?>
use backend\modules\imagesUpload\models\ImagesUploadModel;
use backend\modules\imagesUpload\widgets\imagesUpload\ImageUpload;
use common\models\base\EntityToFile;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
<?php } ?>

/**
 * Class <?= StringHelper::basename($generator->modelClass) . "\n" ?>
 */
class <?= $modelClass ?> extends <?= '\\' . ltrim($generator->baseModelClass, '\\') ?> implements BackendModel
{
<?php if ($generator->isImage) { ?>
    public $titleImage;

    /**
    * Temporary sign which used for saving images before model save
    * @var
    */
    public $sign;

    public function init()
    {
        parent::init();

        if (!$this->sign) {
            $this->sign = \Yii::$app->security->generateRandomString();
        }
    }

    /**
    * @inheritdoc
    */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'titleImage' => \Yii::t('app', 'Title image'),
            'sign' => '',
        ]);
    }

    /**
    * @inheritdoc
    */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['sign'], 'string', 'max' => 255],
        ]);
    }
<?php } ?>
    /**
     * Get title for the template page
     *
     * @return string
     */
    public function getTitle()
    {
        return \Yii::t('app', '<?= Inflector::camel2words(StringHelper::basename($generator->modelClass)) ?>');
    }

    /**
     * Has search form on index template page
     *
     * @return bool
     */
    public function hasSearch()
    {
        return false;
    }

    /**
     * Get attribute columns for index and view page
     *
     * @param $page
     *
     * @return array
     */
    public function getColumns($page)
    {
        switch ($page) {
            case 'index':
                return [
                    ['class' => 'yii\grid\SerialColumn'],

                    <?= implode(",\n                    ", $indexColumns) . ",\n" ?>

                    ['class' => 'yii\grid\ActionColumn'],
                ];
                break;
            case 'view':
                return [
                    <?= implode(",\n                    ", $viewColumns) . ",\n" ?>
                ];
                break;
        }
        return [];
    }

    /**
     * @return \yii\db\ActiveRecord
     */
    public function getSearchModel()
    {
        return new <?= StringHelper::basename($generator->modelClass) ?>Search();
    }

    /**
     * @return array
     */
    public function getFormConfig()
    {
        return [
<?php foreach ($formColumns as $attribute => $config) : ?>
            '<?= $attribute ?>' => <?= $config ?>,
<?php endforeach; ?>
<?php if ($generator->isImage) { ?>
            'titleImage' => [
                'type' => ActiveFormBuilder::INPUT_RAW,
                'value' => ImageUpload::widget([
                    'model' => $this,
                    'attribute' => 'titleImage',
                    //'saveAttribute' => EntityToFile::TYPE_ARTICLE_TITLE_IMAGE, //TODO Создать контанту и раскомментировать
                    'multiple' => false,
                    'uploadUrl' => ImagesUploadModel::uploadUrl([
                        'model_name' => static::className(),
                        'attribute' => 'titleImage',
                        //'entity_attribute' => EntityToFile::TYPE_ARTICLE_TITLE_IMAGE, //TODO Раскомментировать и вписать константу, что сверху
                    ]),
                ])
            ],
            'sign' => [
                'type' => ActiveFormBuilder::INPUT_RAW,
                'value' => Html::activeHiddenInput($this, 'sign'),
            ],
<?php } ?>
        ];
    }

<?php if ($generator->isImage) { ?>
    /**
    * @inheritdoc
    */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        EntityToFile::updateImages($this->id, $this->sign);
    }

    /**
    * @inheritdoc
    */
    public function afterDelete()
    {
        parent::afterDelete();

        EntityToFile::deleteImages($this->formName(), $this->id);
    }

<?php } ?>

}
