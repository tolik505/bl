<?php
/**
 * Created by PhpStorm.
 * User: anatolii
 * Date: 25.06.15
 * Time: 19:15
 */

namespace frontend\components;


use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

class CustomBreadcrumbs extends Breadcrumbs
{
    /**
     * @var string the name of the breadcrumb container tag.
     */
    public $tag = 'ul';
    /**
     * @var array the HTML attributes for the breadcrumb container tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = ['class' => 'breadcrumbs'];
    /**
     * @var string the template used to render each inactive item in the breadcrumbs. The token `{link}`
     * will be replaced with the actual HTML link for each inactive item.
     */
    public $itemTemplate = '<li>{link}</li>';
}
