<?php

namespace frontend\modules\comment\widgets\comments;


use common\models\Comment;
use frontend\modules\article\models\Article;

/**
 * Class Widget
 *
 * @package frontend\modules\comments\widgets\form
 */
class Widget extends \yii\base\Widget
{
    /**
     * @var Article
     */
    public $model;


    public function run()
    {
        $commentModel = new Comment();
        if (\Yii::$app->user->isGuest){
            $commentModel->scenario = 'isGuest';
        }
        $commentModel->model_name = $this->model->formName();
        $commentModel->model_id = $this->model->id;
        $root = $commentModel->getRoot();
        if ($root){
            $commentModels = $root->getChildren();
        } else {
            $commentModels = [];
        }

        return $this->render('default', [
            'commentModel' => $commentModel,
            'model' => $this->model,
            'commentModels' => $commentModels,
        ]);
    }
}
