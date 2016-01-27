<?php

namespace frontend\widgets;

use common\helpers\LanguageHelper;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Class LanguageChecker
 */
class LanguageChecker extends Widget
{
    protected $items = [];

    public function init()
    {
        parent::init();

        $route = '/' . Yii::$app->controller->route;
        $params = $_GET;

        array_unshift($params, $route);

        $models = LanguageHelper::getLanguageModels();

        foreach ($models as $language) {
            $params['language'] = $language->code;
            if (\Yii::$app->language === $language->locale) {
                $this->items[] = Html::tag('span', $language->label);
            } else {
                $this->items[] = Html::a($language->label, $params);
            }
        }
        parent::init();
    }

    /**
     * @return string
     */
    public function run()
    {
        return Html::tag('ul', Html::tag('li', implode('</li><li>', $this->items)), ['class' => 'languages']);
    }

}
