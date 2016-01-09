<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%redirects}}".
 *
 * @property integer $id
 * @property string $from
 * @property string $to
 * @property integer $is_active
 * @property integer $created_at
 * @property integer $updated_at
 */
abstract class Redirects extends \common\components\model\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%redirects}}';
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
            [['from', 'to'], 'required'],
            [['is_active'], 'integer'],
            [['from', 'to'], 'string', 'max' => 255],
            [['from', 'to'], 'url'],
            [['is_active'], 'default', 'value' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'from' => Yii::t('app', 'From'),
            'to' => Yii::t('app', 'To'),
            'is_active' => Yii::t('app', 'Is active'),
        ];
    }
}
