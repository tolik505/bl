<?php

namespace common\models;

use Yii;

/**
 * @inheritdoc
 */
class MailRequest extends \common\models\base\MailRequest
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return \yii\helpers\ArrayHelper::merge(parent::behaviors(), [
            'timestamp' => [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'updatedAtAttribute' => false,
            ],
        ]);
    }

    /**
     * @param $params array
     * @return string
     */
    public static function getSubscribeUrl($params = [])
    {
        return static::createUrl('/request/default/subscribe', $params);
    }
}
