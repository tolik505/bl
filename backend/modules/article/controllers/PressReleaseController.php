<?php

namespace backend\modules\article\controllers;

use backend\components\BackendController;
use backend\modules\article\models\PressRelease;

/**
 * PressReleaseController implements the CRUD actions for Article model.
 */
class PressReleaseController extends BackendController
{
    /**
     * @return string
     */
    public function getModelClass()
    {
        return PressRelease::className();
    }
}
