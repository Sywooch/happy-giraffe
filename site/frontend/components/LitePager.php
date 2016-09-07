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

    /**
     * @var mixed
     */
    public $cssFile = false;

    /**
     * @var string
     */
    public $header = '';

    /**
     * @var integer
     */
    public $maxButtonCount = 10;

    /**
     * @var boolean
     */
    public $showPrevNext = true;

    /**
     * @var string
     */
    public $prevPageLabel = '&nbsp;';

    /**
     * @var string
     */
    public $nextPageLabel = '&nbsp;';

    /**
     * @var boolean
     */
    public $pagerAdaptive = FALSE;

    /**
     * @var string
     */
    public $mobileStyleClass = 'visibles-md';

    /**
     * @var string
     */
    public $desktopStyleClass = 'visibles-lg';

    //-----------------------------------------------------------------------------------------------------------

    /**
     * {@inheritDoc}
     * @see CLinkPager::init()
     */
    public function init()
    {
        $this->appendSeo();
        $this->setLinks();

        parent::init();
    }

    /**
     * {@inheritDoc}
     * @see CLinkPager::run()
     */
    public function run()
    {
        if ($this->pagerAdaptive)
        {
            $this->_renderMobilePager();
        }

        parent::run();
    }

    /**
     * {@inheritDoc}
     * @see CLinkPager::createPageButtons()
     */
    protected function createPageButtons()
    {
        if (($pageCount = $this->getPageCount()) <= 1)
        {
            return [];
        }

        return $this->_createButtons($this->getPageRange());
    }

    /**
     * Render mobile pager
     */
    private function _renderMobilePager()
    {
        $currentPage = $this->getCurrentPage(false);
        $mobButtons = $this->_createButtons([$currentPage, $currentPage]);

        $htmlOptions = $this->htmlOptions;
        $htmlOptions['class'] .= ' ' . $this->mobileStyleClass;
        $htmlOptions['id'] .= 'modile';

        echo $this->header;
        echo CHtml::tag('ul',$htmlOptions,implode("\n",$mobButtons));
        echo $this->footer;

        $this->htmlOptions['class'] .= ' ' . $this->desktopStyleClass;
    }

    /**
     * @param array $arrPageRange
     * @return string[]
     */
    private function _createButtons($arrPageRange)
    {
        $currentPage = $this->getCurrentPage(false); // currentPage is calculated in getPageRange()
        $pageCount = $this->getPageCount();

        list($beginPage, $endPage) = $arrPageRange;
        $buttons = [];

        // prev page
        if (($page = $currentPage - 1) < 0)
        {
            $page = 0;
        }

        $buttons[] = $this->createPageButton($this->prevPageLabel, $page, $this->previousPageCssClass, !$this->showPrevNext || $currentPage <= 0, false);

        // internal pages
        for ($i = $beginPage; $i <= $endPage; ++$i)
        {
            $buttons[] = $this->createPageButton($i + 1, $i, $this->internalPageCssClass, false, $i == $currentPage);
        }

        // next page
        if (($page = $currentPage + 1) >= $pageCount - 1)
        {
            $page = $pageCount - 1;
        }

        $buttons[] = $this->createPageButton($this->nextPageLabel, $page, $this->nextPageCssClass, !$this->showPrevNext || $currentPage >= $pageCount - 1, false);

        return $buttons;
    }

    /**
     * {@inheritDoc}
     * @see CLinkPager::getPageRange()
     */
    protected function getPageRange()
    {
        if ($this->maxButtonCount === null)
        {
            return array(0, $this->getPageCount() - 1);
        }

        return parent::getPageRange();
    }

    /**
     *
     */
    protected function appendSeo()
    {
        if ($this->currentPage == 0)
        {
            return;
        }

        $appendix = ', страница ' . ($this->currentPage + 1);
        Yii::app()->controller->pageTitle .= $appendix;

        if (!empty(Yii::app()->controller->metaDescription))
        {
            Yii::app()->controller->metaDescription .= $appendix;
        }
    }

    /**
     *
     */
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

