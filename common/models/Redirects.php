<?php

namespace common\models;

use Yii;

/**
 * @inheritdoc
 */
class Redirects extends \common\models\base\Redirects
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return \yii\helpers\ArrayHelper::merge(parent::behaviors(), [
            'timestamp' => [
                'class' => \yii\behaviors\TimestampBehavior::className(),
            ],
        ]);
    }

}
