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
    public $maxButtonCount;

    public function init()
    {
        $this->appendSeo();
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

    protected function getPageRange()
    {
        if ($this->maxButtonCount === null) {
            return array(0, $this->getPageCount() - 1);
        } else {
            return parent::getPageRange();
        }
    }


    protected function appendSeo()
    {
        if ($this->currentPage != 0) {
            $appendix = ', страница ' . ($this->currentPage + 1);
            Yii::app()->controller->pageTitle .= $appendix;
            if (! empty(Yii::app()->controller->meta_description)) {
                Yii::app()->controller->meta_description .= $appendix;
            }
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