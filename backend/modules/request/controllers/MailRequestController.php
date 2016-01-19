<?php

namespace backend\modules\request\controllers;

use backend\components\BackendController;
use backend\modules\request\models\MailRequest;

/**
 * MailRequestController implements the CRUD actions for MailRequest model.
 */
class MailRequestController extends BackendController
{
    /**
     * @return string
     */
    public function getModelClass()
    {
        return MailRequest::className();
    }
}
