<?php

namespace frontend\widgets\mainMenu;


use common\components\model\PageUrl;
use frontend\modules\advice\models\Advice;
use frontend\modules\article\models\ArticleCategory;
use frontend\modules\club\models\Club;
use frontend\modules\product\models\Category;
use frontend\modules\product\models\SubCategory;
use frontend\modules\rent\RentModule;
use frontend\modules\service\models\Service;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;

class MainMenuWidget extends Menu
{
    public function run()
    {
        $this->options = [
            'tag' => 'ul',
            'class' => 'nav navbar-nav navbar-right'
        ];

        $this->encodeLabels = false;

        /** @var ArticleCategory[] $categories */
        $categories = ArticleCategory::find()
            ->isPublished()
            ->orderBy('position DESC')
            ->all();
        foreach ($categories as $category){
            $this->items[] = [
                'label' => $category->label,
                'url' => [ArticleCategory::getIndexRoute(), 'alias' => $category->alias],
            ];
        }

        parent::run();
    }

    /**
     * Renders the content of a menu item.
     * Note that the container and the sub-menus are not rendered here.
     * @param array $item the menu item to be rendered. Please refer to [[items]] to see what data might be in the item.
     * @return string the rendering result
     */
    /*protected function renderItem($item)
    {
        if (isset($item['url'])) {
            $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);

            return strtr($template, [
                '{url}' => Html::encode(Url::to($item['url'])),
                '{label}' => $item['label'],
                '{class}' => $item['active'] ? $this->activeCssClass : ''
            ]);
        } else {
            $template = ArrayHelper::getValue($item, 'template', $this->labelTemplate);

            return strtr($template, [
                '{label}' => $item['label'],
            ]);
        }
    }*/
}
