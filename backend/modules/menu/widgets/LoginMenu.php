<?php
/**
 * Author: metal
 * Email: metal
 */

namespace backend\modules\menu\widgets;

use Yii;
use yii\bootstrap\Nav;

/**
 * Class LoginMenu
 * @package backend\modules\menu\widgets
 */
class LoginMenu extends Nav
{
    public $options = ['class' => 'navbar-nav navbar-right'];

    public function init()
    {
        parent::init();

        $items = [];
        if (Yii::$app->user->isGuest) {
            $items[] = ['label' => 'Login', 'url' => ['/admin/default/login']];
        } else {
            $items[] = [
                'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                'url' => ['/admin/default/logout'],
                'linkOptions' => ['data-method' => 'post']
            ];
        }

        $this->items = $items;
    }
}
