<?php

namespace backend\modules\article\controllers;

use backend\components\BackendController;
use backend\modules\article\models\ArticleCategory;

/**
 * ArticleCategoryController implements the CRUD actions for ArticleCategory model.
 */
class ArticleCategoryController extends BackendController
{
    /**
     * @return string
     */
    public function getModelClass()
    {
        return ArticleCategory::className();
    }
}
