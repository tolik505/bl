<?php

namespace common\models\base;

use Yii;
use notgosu\yii2\modules\metaTag\components\MetaTagBehavior;

/**
 * This is the model class for table "page_seo".
 *
 * @property integer $id
 * @property string $label
 */
abstract class PageSeo extends \common\components\model\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page_seo';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return \yii\helpers\ArrayHelper::merge(parent::behaviors(), [
            'seo' => [
                'class' => MetaTagBehavior::className(),
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['label'], 'required'],
            [['label'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'label' => Yii::t('app', 'Label'),
        ];
    }
}
