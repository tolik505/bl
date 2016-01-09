<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%language}}".
 *
 * @property integer $id
 * @property string $label
 * @property string $code
 * @property string $locale
 * @property integer $published
 * @property integer $position
 * @property integer $is_default
 * @property integer $created_at
 * @property integer $updated_at
 */
abstract class Language extends \common\components\model\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%language}}';
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
            [['label', 'code', 'locale'], 'required'],
            [['published', 'position'], 'integer'],
            [['label'], 'string', 'max' => 20],
            [['code', 'locale'], 'string', 'max' => 5],
            [['published'], 'default', 'value' => 1],
            [['position'], 'default', 'value' => 0],
            [['code'], 'unique'],
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
            'code' => Yii::t('app', 'Code'),
            'locale' => Yii::t('app', 'Locale'),
            'published' => Yii::t('app', 'Published'),
            'position' => Yii::t('app', 'Position'),
            'is_default' => Yii::t('app', 'Is default'),
        ];
    }
}
