<?php

namespace backend\modules\seo\models;

use backend\components\BackendModel;
use metalguardian\formBuilder\ActiveFormBuilder;

/**
 * Class PageSeo
 */
class PageSeo extends \common\models\PageSeo implements BackendModel
{

    /**
     * Get title for the template page
     *
     * @return string
     */
    public function getTitle()
    {
        return \Yii::t('app', 'Page Seo');
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
                    'label',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update}'
                    ],
                ];
                break;
            case 'view':
                return [
                    'id',
                    'label',
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
        return new PageSeoSearch();
    }

    /**
     * @return array
     */
    public function getFormConfig()
    {
        return [
            'label' => [
                'type' => ActiveFormBuilder::INPUT_TEXT,
                'options' => [
                    'maxlength' => true,
                ],
            ],
        ];
    }
}
