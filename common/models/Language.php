<?php

namespace common\models;

use Yii;

/**
 * @inheritdoc
 */
class Language extends \common\models\base\Language
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
