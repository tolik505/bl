<?php
/**
 * Author: metal
 * Email: metal
 */

namespace backend\modules\configuration\components;

use backend\modules\configuration\models\Configuration;
use yii\base\InvalidConfigException;
use yii\base\Model;

/**
 * Class ConfigurationModel
 * @package backend\modules\configuration\models
 */
abstract class ConfigurationModel extends Model
{
    protected $models;

    /**
     * Array of configuration keys to manage on form
     *
     * @return array
     */
    abstract public function getKeys();

    /**
     * Save configuration models
     *
     * @return bool
     * @throws \yii\db\Exception
     */
    public function save()
    {
        $transaction = \Yii::$app->getDb()->beginTransaction();
        $saved = true;

        $models = $this->getModels();

        foreach ($models as $item) {
            $saved &= $item->save();
        }

        if (!$saved) {
            $transaction->rollBack();
            return false;
        }

        $transaction->commit();
        return true;
    }

    /**
     * Title of the form
     *
     * @return string
     */
    abstract public function getTitle();

    /**
     * @return Configuration[]
     */
    public function getModels()
    {
        if (null === $this->models) {
            $models = [];
            foreach ($this->getKeys() as $key) {
                $model = Configuration::findOne($key);
                if (!$model) {
                    // create model if it is not created yet
                    $model = new Configuration();
                    $model->id = $key;
                    $model->type = Configuration::TYPE_STRING;
                    $model->preload = 0;
                    $model->published = 1;
                }
                $models[$key] = $model;
            }
            $this->models = $models;
        }

        return $this->models;
    }

    /**
     * Updated method to load configuration language models
     *
     * @inheritdoc
     */
    public static function loadMultiple($models, $data, $formName = null, $key = '')
    {
        if ($formName === null) {
            /* @var $first Model */
            $first = reset($models);
            if ($first === false) {
                return false;
            }
            $formName = $first->formName();
        }

        $success = false;
        foreach ($models as $i => $model) {
            /* @var $model Model */
            if ($formName == '') {
                if (!empty($data[$i])) {
                    $model->load($data[$i], '');
                    $success = true;
                }
            } elseif (!empty($data[$formName][$i])) {
                $model->load($data[$formName][$i], $key);
                $success = true;
            }
        }

        return $success;
    }

    /**
     * @return array
     */
    public function getFormConfig()
    {
        $config = [];

        $models = $this->getModels();

        foreach ($models as $model) {
            $config["[{$model->id}]value"] = $model->getValueFieldConfig();
        }

        return $config;
    }

    /**
     * @return array
     */
    abstract public static function getUpdateUrl();
}
