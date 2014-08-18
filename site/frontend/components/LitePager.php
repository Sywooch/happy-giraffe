<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 31/07/14
 * Time: 11:17
 */

class LitePager extends CLinkPager
{
    public $cssFile = false;
    public $header = '';

    public function init()
    {
        $this->appendTitle();
        $this->appendDescription();
        $this->setLinks();

        parent::init();
    }

    protected function createPageButtons()
    {
        if(($pageCount=$this->getPageCount())<=1)
            return array();

        list($beginPage,$endPage)=$this->getPageRange();
        $currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()
        $buttons=array();

        // internal pages
        for($i=$beginPage;$i<=$endPage;++$i)
            $buttons[]=$this->createPageButton($i+1,$i,$this->internalPageCssClass,false,$i==$currentPage);

        return $buttons;
    }

    protected function appendTitle()
    {
        if ($this->currentPage != 0) {
            Yii::app()->controller->pageTitle .= ', страница ' . ($this->currentPage + 1);
        }
    }

    protected function appendDescription()
    {
        if (! empty(Yii::app()->controller->meta_description)) {
            Yii::app()->controller->meta_description .= ', страница ' . ($this->currentPage + 1);
        }
    }

    protected function setLinks()
    {
        /**
         * @var ClientScript $cs
         */
        $cs = Yii::app()->clientScript;
        $currentPage = $this->getCurrentPage();
        $pageCount = $this->getPageCount();

        // prev
        if (($page = $currentPage - 1) < 0) {
            $page = 0;
        }
        if ($currentPage > 0) {
            $cs->registerLinkTag('prev', null, $this->createPageUrl($page));
        }

        //next
        if (($page = $currentPage + 1) >= $pageCount - 1) {
            $page = $pageCount - 1;
        }
        if ($currentPage < $pageCount - 1) {
            $cs->registerLinkTag('next', null, $this->createPageUrl($page));
        }

        // first
        if ($currentPage > 0) {
            $cs->registerLinkTag('first', null, $this->createPageUrl(0));
        }

        // last
        if ($currentPage < $pageCount-1) {
            $cs->registerLinkTag('last', null, $this->createPageUrl($pageCount - 1));
        }
    }
} 