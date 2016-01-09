<?php

namespace backend\modules\article\controllers;

use backend\components\BackendController;
use backend\modules\article\models\ExploreArticle;

/**
 * ExploreArticleController implements the CRUD actions for Article model.
 */
class ExploreArticleController extends BackendController
{
    /**
     * @return string
     */
    public function getModelClass()
    {
        return ExploreArticle::className();
    }
}
