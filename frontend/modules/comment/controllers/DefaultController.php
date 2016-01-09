<?php

namespace frontend\modules\comment\controllers;

use common\models\Comment;
use frontend\modules\article\models\Article;
use frontend\modules\comment\widgets\comments\Widget;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    public function actionAddComment()
    {
        if (\Yii::$app->request->isAjax) {
            $model = new Comment();
            if (\Yii::$app->user->isGuest){
                $model->scenario = 'isGuest';
            }
            $data = ['error' => true];
            if ($model->load(\Yii::$app->request->post())) {
                $parentID = \Yii::$app->request->post('parent_id');
                $root = $model->makeRootIfNotExist();

                if (!$parentID){
                    $model->appendTo($root);
                } else {
                    $parent = Comment::find()
                        ->where(['id' => $parentID])
                        ->one();
                    $model->appendTo($parent);
                }
                $articleModel = Article::findOne($model->model_id);
                $data = ['replaces' => [
                    [
                        'what' => '#comments',
                        'data' => $this->renderAjax('@app/themes/basic/modules/article/views/default/_comments', ['model' => $articleModel])
                    ]
                ]];
            }

            return Json::encode($data);
        } else {
            throw new NotFoundHttpException(\Yii::t('app', 'Page not found'));
        }
    }
}
