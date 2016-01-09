<?php
/**
 * @author walter
 */

namespace frontend\components;


use yii\web\NotFoundHttpException;

class Pagination extends \yii\data\Pagination {

    private $_page;

    /**
     * Returns the zero-based current page number.
     * @param boolean $recalculate whether to recalculate the current page based on the page size and item count.
     * @return integer the zero-based current page number.
     */
    public function getPage($recalculate = false)
    {
        if ($this->_page === null || $recalculate) {
            $page = (int) $this->getQueryParam($this->pageParam, 1) - 1;
            $this->setPage($page, true);
        }

        $page = isset($page) ? $page + 1 : $this->getQueryParam($this->pageParam, 1);
        if ($page) {
            $pagesCount = ceil($this->totalCount/$this->pageSize);
            if ($pagesCount < (int) $page) {
                throw new NotFoundHttpException;
            }
        }

        return parent::getPage();
    }

} 