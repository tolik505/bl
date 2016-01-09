<?php

namespace backend\modules\seo\controllers;

use backend\components\BackendController;
use backend\modules\seo\models\PageSeo;

/**
 * PageSeoController implements the CRUD actions for PageSeo model.
 */
class PageSeoController extends BackendController
{
    /**
     * @return string
     */
    public function getModelClass()
    {
        return PageSeo::className();
    }
}
