<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%configuration_translation}}".
 *
 * @property string $model_id
 * @property string $language
 * @property string $value
 */
abstract class ConfigurationTranslation extends \common\components\model\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%configuration_translation}}';
    }
}
