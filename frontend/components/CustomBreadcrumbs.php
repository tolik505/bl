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
    public $tag = 'div';
    /**
     * @var array the HTML attributes for the breadcrumb container tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = ['class' => 'info-nav__breadcrumb'];
    /**
     * @var string the template used to render each inactive item in the breadcrumbs. The token `{link}`
     * will be replaced with the actual HTML link for each inactive item.
     */
    public $itemTemplate = '{link}';
    /**
     * @var string the template used to render each active item in the breadcrumbs. The token `{link}`
     * will be replaced with the actual HTML link for each active item.
     */
    public $activeItemTemplate = false;


    /**
     * Renders the widget.
     */
    public function run()
    {
        $links[] = \Yii::t('app', 'Back to:');
        $links[] = $this->renderItem([
            'label' => \Yii::t('app', 'Home'),
            'url' => \Yii::$app->homeUrl,
        ], $this->itemTemplate);

        foreach ($this->links as $link) {
            if (!is_array($link)) {
                $link = ['label' => $link];
            }
            $links[] = $this->renderItem($link, isset($link['url']) ? $this->itemTemplate : $this->activeItemTemplate);
        }
        echo Html::tag($this->tag, implode('', $links), $this->options);
    }
}
