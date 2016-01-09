<?php
/**
 * Author: metal
 * Email: metal
 */

namespace common\components;

use common\components\model\Translateable;
use common\helpers\LanguageHelper;

/**
 * Class Translate
 * @package common\components
 */
trait Translate
{
    /**
     * @param $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        if ($this instanceof Translateable && in_array($name, $this->getTranslationAttributes(), true)) {
            $defaultLanguage = LanguageHelper::getDefaultLanguage()->locale;
            $language = \Yii::$app->language;
            if ($defaultLanguage === $language) {
                return parent::__get($name);
            }
            /** @var \yii\db\ActiveRecord $translation */
            $translation = $this->translate($language);
            if ($translation->isNewRecord) {
                return parent::__get($name);
            }
            return $translation->$name;
        }
        return parent::__get($name);
    }
}
