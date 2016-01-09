<?php

namespace backend\modules\configuration\controllers;

use backend\components\BackendController;
use backend\modules\configuration\models\ConfigurationTranslation;
use common\components\model\Translateable;
use common\helpers\LanguageHelper;
use Yii;
use backend\modules\configuration\models\Configuration;
use yii\helpers\Json;

/**
 * DefaultController implements the CRUD actions for Configuration model.
 */
class DefaultController extends BackendController
{
    /**
     * @inheritdoc
     */
    public function getModelClass()
    {
        return Configuration::className();
    }

    /**
     * @return string
     */
    public function actionGetForm()
    {
        $post = \Yii::$app->request->post();
        $id = $post[(new Configuration())->formName()]['id'];
        $model = Configuration::findOne($id);
        if (!$model) {
            $model = new Configuration();
        }
        $model->load(\Yii::$app->request->post());

        $model->value = null;
        /** @var ConfigurationTranslation[] $translationModels */
        $translationModels = $model->getTranslationModels();
        foreach ($translationModels as $languageModel) {
            $languageModel->value = null;
        }
        //Save model for setting actual scenario in translation model
        if (!$model->isNewRecord) {
            $model->save(false);
        }

        return Json::encode(
            [
                'replaces' => [
                    [
                        'what' => '.menu-form',
                        'data' => $this->renderAjax(
                            '//templates/_form',
                            [
                                'model' => $model,
                                'action' => \Yii::$app->request->post('action', '')
                            ]
                        )
                    ]
                ]
            ]
        );
    }


}
