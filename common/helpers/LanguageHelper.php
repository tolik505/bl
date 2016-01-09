<?php
/**
 * Author: metal
 * Email: metal
 */

namespace common\helpers;

use common\models\Language;
use Yii;

/**
 * Class LanguageHelper
 * @package common\helpers
 */
class LanguageHelper
{
    /**
     * @var Language
     */
    private static $current;

    /**
     * @var array
     */
    private static $models = [];

    /**
     * @var
     */
    private static $default;

    /**
     * @return Language
     */
    public static function getCurrent()
    {
        if (static::$current === null) {
            static::$current = static::getDefaultLanguage();
        }
        return static::$current;
    }

    /**
     * @return Language
     */
    public static function getDefaultLanguage()
    {
        if (static::$default === null) {
            static::$default = Language::find()->where(['is_default' => 1])->one();
        }
        return static::$default;
    }

    /**
     * @return bool
     */
    public static function isCurrentDefault()
    {
        return static::getCurrent()->locale === static::getDefaultLanguage()->locale;
    }

    /**
     * @return Language[]
     */
    public static function getLanguageModels()
    {
        if (empty(static::$models)) {
            static::$models = Language::find()->isPublished()->orderBy(['position' => SORT_DESC])->all();
        }

        return static::$models;
    }

    /**
     * @param string $code
     *
     * @return bool
     */
    public static function setCurrent($code)
    {
        $language = Language::find()->where(['code' => $code])->one();
        if ($language) {
            self::$current = $language;
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public static function getApplicationLanguages()
    {
        $models = static::getLanguageModels();
        $languages = [];
        foreach ($models as $model) {
            $languages[] = $model->locale;
        }
        return $languages;
    }
}
