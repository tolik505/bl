<?php
/**
 * Author: metal
 * Email: metal
 */

namespace common\components;

use common\models\Configuration;
use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Component;
use yii\base\InvalidConfigException;

/**
 * Class ConfigurationComponent
 * @package common\components
 */
class ConfigurationComponent extends Component implements BootstrapInterface
{
    /**
     * Default language
     *
     * @var string|\Closure
     */
    public $defaultLanguage = 'en';

    protected $configs = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->defaultLanguage instanceof \Closure) {
            $this->defaultLanguage = call_user_func($this->defaultLanguage);
        }

        if (!is_string($this->defaultLanguage)) {
            throw new InvalidConfigException(Yii::t('app', 'ConfigurationComponent::defaultLanguage have to be string'));
        }
    }

    /**
     * Bootstrap method to be called during application bootstrap stage.
     *
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        /** @var Configuration[] $configs */
        $configs = Configuration::find()
            ->select(['id', 'value', 'type'])
            ->with(['translations'])
            ->where(['preload' => 1, 'published' => 1])
            ->all();

        foreach ($configs as $config) {
            $key = $config['id'];
            $this->configs[$key]['type'] = (int) $config['type'];

            $this->configs[$key][$this->defaultLanguage] = $config['value'];

            foreach ($config['translations'] as $item) {
                $this->configs[$key][$item['language']] = $item['value'];
            }
        }
    }

    /**
     * Get config
     *
     * @param $key
     * @param null $defaultValue
     * @param bool $language
     *
     * @return int|null|string
     */
    public function get($key, $defaultValue = null, $language = false)
    {
        if ($this->has($key)) {
            return $this->getValue($key, $language);
        }

        $this->set($key);
        if (!$this->has($key)) {
            return $defaultValue;
        }
        return $this->getValue($key, $language);
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function set($key)
    {
        /** @var Configuration $config */
        $config = Configuration::find()
            ->select(['id', 'value', 'type'])
            ->with(['translations'])
            ->where(['id' => $key, 'published' => 1])
            ->asArray()
            ->one();

        if (null === $config) {
            return false;
        }

        $this->configs[$key]['type'] = (int) $config['type'];

        $this->configs[$key][$this->defaultLanguage] = $config['value'];

        foreach ($config['translations'] as $item) {
            $this->configs[$key][$item['language']] = $item['value'];
        }

        return true;
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function has($key)
    {
        return isset($this->configs[$key]);
    }

    /**
     * Return value by type
     *
     * @param $key
     * @param $language
     *
     * @return int|null|string
     */
    protected function getValue($key, $language)
    {
        if ($language === false) {
            $language = Yii::$app->language;
        }

        $config = $this->configs[$key];
        if (isset($config[$language])) {
            $value = $config[$language];
        } else {
            // if no translate for the language - we use default language
            $value = $config[$this->defaultLanguage];
        }

        switch ($config['type']) {
            case Configuration::TYPE_STRING:
            case Configuration::TYPE_HTML:
            case Configuration::TYPE_TEXT:
                $value = (string) $value;
                break;
            case Configuration::TYPE_INTEGER:
            case Configuration::TYPE_BOOLEAN:
                $value = (int) $value;
                break;
            case Configuration::TYPE_DOUBLE:
                $value = (float) $value;
                break;
        }
        return $value;
    }
}
