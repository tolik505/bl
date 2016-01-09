<?php

namespace backend\modules\article\models;

use backend\components\BackendModel;
use metalguardian\formBuilder\ActiveFormBuilder;

/**
 * Class ArticleCategory
 */
class ArticleCategory extends \common\models\ArticleCategory implements BackendModel
{
    /**
     * Get title for the template page
     *
     * @return string
     */
    public function getTitle()
    {
        return \Yii::t('app', 'Article Category');
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

                    // 'id',
                    'label',
                    'alias',
                    'published:boolean',
                    'position',

                    ['class' => 'yii\grid\ActionColumn'],
                ];
                break;
            case 'view':
                return [
                    'id',
                    'label',
                    'alias',
                    'published:boolean',
                    'position',
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
        return new ArticleCategorySearch();
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
                    'class' => 's_name'
                ],
            ],
            'alias' => [
                'type' => ActiveFormBuilder::INPUT_TEXT,
                'options' => [
                    'maxlength' => true,
                    'class' => 's_alias'
                ],
            ],
            'published' => [
                'type' => ActiveFormBuilder::INPUT_CHECKBOX,
            ],
            'position' => [
                'type' => ActiveFormBuilder::INPUT_TEXT,
            ],
        ];
    }


}
