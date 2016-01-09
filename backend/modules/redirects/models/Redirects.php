<?php

namespace backend\modules\redirects\models;

use backend\components\BackendModel;
use metalguardian\formBuilder\ActiveFormBuilder;
use yii\helpers\Html;

/**
 * Class Redirects
 */
class Redirects extends \common\models\Redirects implements BackendModel
{

    /**
     * Get title for the template page
     *
     * @return string
     */
    public function getTitle()
    {
        return \Yii::t('app', 'Redirects');
    }

    /**
     * Has search form on index template page
     *
     * @return bool
     */
    public function hasSearch()
    {
        return false;
    }

    /**
     * Get attribute columns for index and view page
     *
     * @param $page
     *
     * @return array
     */
    public function getColumns($page)
    {
        switch ($page) {
            case 'index':
                return [
                    'id',
                    'from',
                    'to',
                    'is_active:boolean',
                    [ 'class' => 'yii\grid\ActionColumn' ],
                ];
                break;
            case 'view':
                return [
                    'id',
                    'from',
                    'to',
                    'is_active:boolean',
                ];
                break;
        }
        return [];
    }

    /**
     * @return \yii\db\ActiveRecord
     */
    public function getSearchModel()
    {
        return new RedirectsSearch();
    }

    /**
     * @return array
     */
    public function getFormConfig()
    {
        return [
            'from' => [
                'type' => ActiveFormBuilder::INPUT_TEXT,
                'options' => [
                    'maxlength' => true,
                ],
            ],
            'to' => [
                'type' => ActiveFormBuilder::INPUT_TEXT,
                'options' => [
                    'maxlength' => true,
                ],
            ],
            'is_active' => [
                'type' => ActiveFormBuilder::INPUT_CHECKBOX,
            ],
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->clearCache();
        return parent::afterSave($insert, $changedAttributes);
    }

    public function beforeDelete()
    {
        $this->clearCache();
        return parent::beforeDelete();
    }

    public function clearCache()
    {
        $cache = new \Cache([
            'path' => __DIR__ . '/../../../../frontend/runtime/redirectCache/',
            'name' => 'default',
            'extension' => '.cache',
        ]);
        if ($cache->retrieve($this->from)) {
            $cache->erase($this->from);
        }
    }

    public static function clearAllCache()
    {
        $cache = new \Cache([
            'path' => __DIR__ . '/../../../../frontend/runtime/redirectCache/',
            'name' => 'default',
            'extension' => '.cache',
        ]);
        $cache->eraseAll();
    }
}
