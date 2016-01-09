<?php

namespace backend\modules\language\controllers;

use backend\components\BackendController;
use backend\modules\language\models\Language;

/**
 * LanguageController implements the CRUD actions for Language model.
 */
class LanguageController extends BackendController
{
    /**
     * @return string
     */
    public function getModelClass()
    {
        return Language::className();
    }
}
