<?php

namespace frontend\modules\request\controllers;

use common\models\MailRequest;
use frontend\components\FrontendController;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `request` module
 */
class DefaultController extends FrontendController
{
    public function actionSubscribe()
    {
        $model = new MailRequest();

        if (\Yii::$app->request->isAjax) {
            $model->load(\Yii::$app->request->post());
            $success = false;
            if ($model->save()) {
                //$model->sendEmail();
                $model = new MailRequest();
                $success = true;
            }

            return Json::encode([
                'replaces' => [
                    [
                        'data' => $this->renderAjax('@app/themes/basic/layouts/_subscribe_form', [
                            'model' => $model,
                            'success' => $success
                        ]),
                        'what' => '.mail-subscribe-widget'
                    ],
                ],
            ]);
        }

        throw new NotFoundHttpException;
    }
}
