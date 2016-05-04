<?php

namespace frontend\widgets\mainMenu;


use frontend\components\DummyModel;
use frontend\modules\article\models\ArticleCategory;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;

/**
 * Class MainMenuWidget
 *
 * @package frontend\widgets\mainMenu
 */
class MainMenuWidget extends Menu
{
    /**
     * Renders the menu.
     */
    public function run()
    {
        $this->options = [
            'tag' => 'ul',
            'class' => 'nav navbar-nav navbar-right'
        ];

        $this->encodeLabels = false;

        $this->items[] = [
            'label' => \Yii::t('app', 'Home'),
            'url' => [DummyModel::getHomeRoute()],
        ];
        /** @var ArticleCategory[] $categories */
        $categories = ArticleCategory::find()
            ->from(['t' => ArticleCategory::tableName()])
            ->joinWith(['articles'], true, 'RIGHT JOIN')
            ->andWhere(['t.published' => 1])
            ->orderBy('t.position DESC, t.id')
            ->groupBy('t.id')
            ->all();
        \Yii::$app->params['categoryModels'] = $categories;
        foreach ($categories as $category) {
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
    protected function renderItem($item)
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
    }
}
