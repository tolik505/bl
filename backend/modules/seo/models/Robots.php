<?php

namespace backend\modules\seo\models;

use backend\components\BackendModel;
use metalguardian\formBuilder\ActiveFormBuilder;

/**
 * Class Robots
 */
class Robots extends \common\models\Robots implements BackendModel
{

    /**
     * Get title for the template page
     *
     * @return string
     */
    public function getTitle()
    {
        return \Yii::t('app', 'Robots.txt');
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
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'text:ntext',

                    ['class' => 'yii\grid\ActionColumn'],
                ];
                break;
            case 'view':
                return [
                    'id',
                    'text:ntext',
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
        return new RobotsSearch();
    }

    /**
     * @return array
     */
    public function getFormConfig()
    {
        return [
            'text' => [
                'type' => ActiveFormBuilder::INPUT_TEXTAREA,
                'options' => [
                    'rows' => 6,
                ],
                'hint' => \Yii::t('app', 'Each new option must be on new line.')
            ],
        ];
    }
}
