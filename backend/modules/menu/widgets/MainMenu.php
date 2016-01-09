<?php
/**
 * Author: metal
 * Email: metal
 */

namespace backend\modules\menu\widgets;

use common\models\User;
use Yii;
use yii\bootstrap\Nav;

/**
 * Class MainMenu
 * @package backend\modules\menu\widgets
 */
class MainMenu extends Nav
{
    public $options = ['class' => 'navbar-nav'];

    public function init()
    {
        parent::init();

        $items = [];
        if (Yii::$app->user->can(User::ROLE_ADMIN)) {
            $items = Yii::$app->params['menuItems'];
        }

        $this->items = $items;
    }
}
