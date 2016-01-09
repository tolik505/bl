<?php

namespace backend\modules\redirects\controllers;

use backend\components\BackendController;
use backend\modules\redirects\models\Redirects;

/**
 * RedirectsController implements the CRUD actions for Redirects model.
 */
class RedirectsController extends BackendController
{
    /**
     * @return string
     */
    public function getModelClass()
    {
        return Redirects::className();
    }


    /**
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $class = $this->getModelClass();
        /** @var BackendModel $searchModel */
        $searchModel = (new $class)->getSearchModel();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
    }

    public function actionClearCache()
    {
        Redirects::clearAllCache();

        return $this->redirect(['index']);
    }
}
