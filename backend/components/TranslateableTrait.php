<?php
/**
 * Author: metal
 * Email: metal
 */

namespace backend\components;

use common\helpers\LanguageHelper;

/**
 * Trait TranslateableTrait
 * @package backend\components
 */
trait TranslateableTrait
{
    /**
     * @return \yii\base\Model[]
     */
    public function getTranslationModels()
    {
        $models = [];
        $languages = LanguageHelper::getLanguageModels();
        foreach ($languages as $language) {
            if ($language->locale === LanguageHelper::getDefaultLanguage()->locale) {
                continue;
            }
            $models[$language->locale] = $this->getTranslation($language->locale);
        }
        return $models;
    }

    /**
     * @param string $attribute
     *
     * @return bool
     */
    public function isTranslateAttribute($attribute)
    {
        $position = strpos($attribute, ']');
        $attributeName = $position > 0 ? substr($attribute, $position + 1) : $attribute;

        return in_array($attributeName, $this->getTranslationAttributes(), true);
    }
}
