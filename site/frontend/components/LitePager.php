<?php

/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 31/07/14
 * Time: 11:17
 */

/**
 * @property-read LiteController $controller Контроллер, на котором вызван виджет
 */
class LitePager extends CLinkPager
{

    public $cssFile = false;
    public $header = '';
    public $maxButtonCount;
    public $showPrevNext = false;

    public function init()
    {
        $this->appendSeo();
        $this->setLinks();

        parent::init();
    }

    protected function createPageButtons()
    {
        if (($pageCount = $this->getPageCount()) <= 1)
            return array();

        list($beginPage, $endPage) = $this->getPageRange();
        $currentPage = $this->getCurrentPage(false); // currentPage is calculated in getPageRange()
        $buttons = array();

        // prev page
        if (($page = $currentPage - 1) < 0)
            $page = 0;
        $buttons[] = $this->createPageButton($this->prevPageLabel, $page, $this->previousPageCssClass, !$this->showPrevNext || $currentPage <= 0, false);

        // internal pages
        for ($i = $beginPage; $i <= $endPage; ++$i)
            $buttons[] = $this->createPageButton($i + 1, $i, $this->internalPageCssClass, false, $i == $currentPage);

        // next page
        if (($page = $currentPage + 1) >= $pageCount - 1)
            $page = $pageCount - 1;
        $buttons[] = $this->createPageButton($this->nextPageLabel, $page, $this->nextPageCssClass, !$this->showPrevNext || $currentPage >= $pageCount - 1, false);

        return $buttons;
    }

    protected function getPageRange()
    {
        if ($this->maxButtonCount === null)
        {
            return array(0, $this->getPageCount() - 1);
        }
        else
        {
            return parent::getPageRange();
        }
    }

    protected function appendSeo()
    {
        if ($this->currentPage != 0)
        {
            $appendix = ', страница ' . ($this->currentPage + 1);
            Yii::app()->controller->pageTitle .= $appendix;
            if (!empty(Yii::app()->controller->metaDescription))
            {
                Yii::app()->controller->metaDescription .= $appendix;
            }
        }
    }

    protected function setLinks()
    {
        $currentPage = $this->getCurrentPage();
        $pageCount = $this->getPageCount();

        if ($currentPage > 0)
            $this->controller->metaNavigation->prev = $this->createPageUrl($currentPage - 1);

        if ($currentPage < $pageCount - 1)
            $this->controller->metaNavigation->next = $this->createPageUrl($currentPage + 1);

        if ($currentPage > 0)
            $this->controller->metaNavigation->first = $this->createPageUrl(0);

        if ($currentPage < $pageCount - 1)
            $this->controller->metaNavigation->last = $this->createPageUrl($pageCount - 1);
    }

}

