<?php

namespace common\models;

use Yii;

/**
 * @inheritdoc
 *
 * @property ConfigurationTranslation[] $translations
 */
class Configuration extends \common\models\base\Configuration implements \common\components\model\Translateable
{
    use \backend\components\TranslateableTrait;

    /**
     * @return array
     */
    public static function getTranslationAttributes()
    {
        return [
            'value',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return \yii\helpers\ArrayHelper::merge(parent::behaviors(), [
            'translateable' => [
                'class' => \creocoder\translateable\TranslateableBehavior::className(),
                'translationAttributes' => static::getTranslationAttributes(),
            ],
            'timestamp' => [
                'class' => \yii\behaviors\TimestampBehavior::className(),
            ],
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(ConfigurationTranslation::className(), ['model_id' => 'id']);
    }

}
