<?php

namespace frontend\components;

use yii\helpers\Html;

/**
 * Class LinkPager
 * @package frontend\components
 */
class LinkPager extends \yii\widgets\LinkPager
{
    /** @inheritdoc */
    public $options = ['id' => 'pagination'];
    /** @inheritdoc */
    public $pageCssClass = 'page-num';
    /** @inheritdoc */
    public $activePageCssClass = 'current';
    /** @inheritdoc */
    public $disabledPageCssClass = 'all-pages';


    /**
     * Renders the page buttons.
     * @return string the rendering result
     */
    protected function renderPageButtons()
    {
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }

        $buttons = [];
        $currentPage = $this->pagination->getPage();

        // first page
        $firstPageLabel = $this->firstPageLabel === true ? '1' : $this->firstPageLabel;
        if ($firstPageLabel !== false) {
            $buttons[] = $this->renderPageButton($firstPageLabel, 0, $this->firstPageCssClass, $currentPage <= 0, false);
        }

        // prev page
        if ($this->prevPageLabel !== false) {
            if (($page = $currentPage - 1) < 0) {
                $page = 0;
            }
            $buttons[] = $this->renderPageButton(
                \Yii::t('app', 'Prev'),
                $page,
                'prev-page',
                $currentPage <= 0,
                false
            );
        }

        // internal pages
        list($beginPage, $endPage) = $this->getPageRange();
        for ($i = $beginPage; $i <= $endPage; ++$i) {
            $buttons[] = $this->renderPageButton($i + 1, $i, $this->pageCssClass, false, $i == $currentPage);
        }

        // next page
        if ($this->nextPageLabel !== false) {
            if (($page = $currentPage + 1) >= $pageCount - 1) {
                $page = $pageCount - 1;
            }
            $buttons[] = $this->renderPageButton(
                \Yii::t('app', 'Next'),
                $page,
                'next-page',
                $currentPage >= $pageCount - 1,
                false
            );
        }

        // last page
        $lastPageLabel = $this->lastPageLabel === true ? $pageCount : $this->lastPageLabel;
        if ($lastPageLabel !== false) {
            $buttons[] = $this->renderPageButton($lastPageLabel, $pageCount - 1, $this->lastPageCssClass, $currentPage >= $pageCount - 1, false);
        }

        $return = Html::beginTag('div', $this->options);
        $return .= implode("\n", $buttons);
        $return .= Html::endTag('div');

        return $return;
    }

    /**
     * Renders a page button.
     * You may override this method to customize the generation of page buttons.
     * @param string $label the text label for the button
     * @param integer $page the page number
     * @param string $class the CSS class for the page button.
     * @param boolean $disabled whether this page button is disabled
     * @param boolean $active whether this page button is active
     * @return string the rendering result
     */
    protected function renderPageButton($label, $page, $class, $disabled, $active)
    {
        $options = ['class' => $class === '' ? null : $class];
        if ($active) {
            Html::addCssClass($options, $this->activePageCssClass);

            return Html::tag('span', $label, $options);
        }
        if ($disabled) {
            Html::addCssClass($options, $this->disabledPageCssClass);

            return Html::tag('span', $label, $options);
        }

        $return = Html::a($label, $this->pagination->createUrl($page), $options);

        return $return;
    }
}
