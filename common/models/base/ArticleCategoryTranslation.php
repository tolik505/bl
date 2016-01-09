<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "article_category_translation".
 *
 * @property integer $model_id
 * @property string $language
 * @property string $label
 */
abstract class ArticleCategoryTranslation extends \common\components\model\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_category_translation';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return \yii\helpers\ArrayHelper::merge(parent::behaviors(), [
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['label'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'label' => Yii::t('app', 'Label') . ' [' . $this->language . ']',
        ];
    }
}
