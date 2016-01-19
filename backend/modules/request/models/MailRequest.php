<?php

namespace backend\modules\request\models;

use backend\components\BackendModel;
use metalguardian\formBuilder\ActiveFormBuilder;

/**
 * Class MailRequest
 */
class MailRequest extends \common\models\MailRequest implements BackendModel
{
    /**
     * Get title for the template page
     *
     * @return string
     */
    public function getTitle()
    {
        return \Yii::t('app', 'Mail Request');
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
                    'language',
                    //'status:boolean',

                    ['class' => 'yii\grid\ActionColumn'],
                ];
                break;
            case 'view':
                return [
                    'id',
                    'label',
                    'language',
                    //'status:boolean',
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
        return new MailRequestSearch();
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
            'language' => [
                'type' => ActiveFormBuilder::INPUT_TEXT,
                'options' => [
                    'maxlength' => true,
                    
                ],
            ],
            /*'status' => [
                'type' => ActiveFormBuilder::INPUT_CHECKBOX,
            ],*/
        ];
    }


}
