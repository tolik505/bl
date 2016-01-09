<?php

namespace common\models;

use Yii;

/**
 * @inheritdoc
 *
 * @property Configuration $model
 */
class ConfigurationTranslation extends \common\models\base\ConfigurationTranslation
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModel()
    {
        return $this->hasOne(Configuration::className(), ['id' => 'model_id']);
    }

}
