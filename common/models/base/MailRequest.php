<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "mail_request".
 *
 * @property integer $id
 * @property string $label
 * @property string $language
 * @property integer $status
 * @property integer $created_at
 */
abstract class MailRequest extends \common\components\model\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mail_request';
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
            [['label', 'language'], 'required'],
            [['label'], 'email'],
            [['status'], 'integer'],
            [['label', 'language'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => 0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'label' => Yii::t('app', 'Email'),
            'language' => Yii::t('app', 'Language'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}
