<?php
/**
 * Created by PhpStorm.
 * User: anatolii
 * Date: 29.10.15
 * Time: 12:09
 */

namespace frontend\components;


use frontend\modules\request\RequestModule;
use yii\widgets\ActiveForm;
use yii\db\ActiveRecord;

class CustomForm extends ActiveForm
{
    /** @var  ActiveRecord */
    public $model;

    public function init()
    {
        $this->id = $this->model->formName();
        $this->action = RequestModule::getPopupUrl(['type' => $this->model->tableName()]);
        $this->fieldConfig = [
            'template' => '<div class="row">{input}{error}</div>',
            'errorOptions' => [
                'class' => 'errorMessage',
            ],
        ];

        parent::init();
    }
}
