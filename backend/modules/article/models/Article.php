<?php

namespace backend\modules\article\models;

use backend\components\BackendModel;
use metalguardian\formBuilder\ActiveFormBuilder;
use backend\modules\imagesUpload\models\ImagesUploadModel;
use backend\modules\imagesUpload\widgets\imagesUpload\ImageUpload;
use common\models\base\EntityToFile;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class Article
 */
class Article extends \common\models\Article implements BackendModel
{
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
    /**
     * Get title for the template page
     *
     * @return string
     */
    public function getTitle()
    {
        return \Yii::t('app', 'Article');
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

                    // 'id',
                    'label',
                    'alias',
                    [
                        'attribute' => 'category_id',
                        'filter' => ArticleCategory::getItems(),
                        'value' => function (self $data) {
                            return isset($data->category->label) ? $data->category->label : '';
                        },
                    ],
                    // 'announce:ntext',
                    // 'content:ntext',
                    'date',
                    'tags',
                    'views',
                    'published:boolean',
                    'position',

                    ['class' => 'yii\grid\ActionColumn'],
                ];
                break;
            case 'view':
                return [
                    'id',
                    'label',
                    'alias',
                    [
                        'attribute' => 'category_id',
                        'filter' => ArticleCategory::getItems(),
                        'value' => isset($this->category->label) ? $this->category->label : '',
                    ],
                    [
                        'attribute' => 'announce',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'content',
                        'format' => 'html',
                    ],
                    'date',
                    'tags',
                    'views',
                    'published:boolean',
                    'position',
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
        return new ArticleSearch();
    }

    /**
     * @return array
     */
    public function getFormConfig()
    {
        return [
            'label' => [
                'type' => ActiveFormBuilder::INPUT_TEXT,
                'options' => [
                    'maxlength' => true,
                    'class' => 's_name'
                ],
            ],
            'alias' => [
                'type' => ActiveFormBuilder::INPUT_TEXT,
                'options' => [
                    'maxlength' => true,
                    'class' => 's_alias'
                ],
            ],
            'category_id' => [
                'type' => ActiveFormBuilder::INPUT_DROPDOWN_LIST,
                'items' => \common\models\ArticleCategory::getItems(),
                'options' => [
                    'prompt' => '',
                ],
            ],
            'announce' => [
                'type' => ActiveFormBuilder::INPUT_WIDGET,
                'widgetClass' => \backend\components\ImperaviContent::className(),
                'options' => [
                    'model' => $this,
                    'attribute' => 'announce',
                ]
            ],
            'content' => [
                'type' => ActiveFormBuilder::INPUT_WIDGET,
                'widgetClass' => \backend\components\ImperaviContent::className(),
                'options' => [
                    'model' => $this,
                    'attribute' => 'content',
                ]
            ],
            'date' => [
                'type' => ActiveFormBuilder::INPUT_WIDGET,
                'widgetClass' => \metalguardian\dateTimePicker\Widget::className(),
                'options' => [
                    'mode' => \metalguardian\dateTimePicker\Widget::MODE_DATE,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ],
            'titleImage' => [
                'type' => ActiveFormBuilder::INPUT_RAW,
                'value' => ImageUpload::widget([
                    'model' => $this,
                    'attribute' => 'titleImage',
                    'saveAttribute' => EntityToFile::TYPE_ARTICLE_TITLE_IMAGE,
                    'multiple' => false,
                    'aspectRatio' => 848/350,
                    'uploadUrl' => ImagesUploadModel::uploadUrl([
                        'model_name' => static::className(),
                        'attribute' => 'titleImage',
                        'entity_attribute' => EntityToFile::TYPE_ARTICLE_TITLE_IMAGE,
                    ]),
                ])
            ],
            'tags' => [
                'type' => ActiveFormBuilder::INPUT_TEXT,
                'options' => [
                    'maxlength' => true,
                    
                ],
            ],
            'views' => [
                'type' => ActiveFormBuilder::INPUT_TEXT,
            ],
            'published' => [
                'type' => ActiveFormBuilder::INPUT_CHECKBOX,
            ],
            'position' => [
                'type' => ActiveFormBuilder::INPUT_TEXT,
            ],
            'sign' => [
                'type' => ActiveFormBuilder::INPUT_RAW,
                'value' => Html::activeHiddenInput($this, 'sign'),
            ],
        ];
    }

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


}
