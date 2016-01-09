<?php
/**
 * Author: metal
 * Email: metal
 */

namespace common\components\model;

/**
 * Class Translateable
 * @package common\components\model
 */
interface Translateable
{
    /**
     * List of attributes to translate
     *
     * @return array
     */
    public static function getTranslationAttributes();

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations();

    /**
     * @return \yii\base\Model[]
     */
    public function getTranslationModels();

    /**
     * @param string $attribute
     *
     * @return bool
     */
    public function isTranslateAttribute($attribute);
}
