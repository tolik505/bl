<?php

namespace backend\modules\article\controllers;

use backend\components\BackendController;
use backend\modules\article\models\Article;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends BackendController
{
    /**
     * @return string
     */
    public function getModelClass()
    {
        return Article::className();
    }
}
