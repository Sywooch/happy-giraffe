<?php

/**
 * @author Sergey Gubarev
 */
class LitePagerDots extends LitePager
{
    const PAGE_FIRST = 1;
    
    //-----------------------------------------------------------------------------------------------------------
    
    /**
     * Кол-во видимых страниц по умолчанию
     * p.s. Без учета первой и последней страниц
     * 
     * @var integer
     */
    public $showButtonCount = 5;
    
    /**
     * Разметка для точек
     * 
     * @var string
     */
    public $dotsLabel = '...';
    
    /**
     * Индекс от текущей страница (от 0)
     * 
     * @var integer
     */
    private $_pageIndex;
    
    /**
     * Текущая страница
     * 
     * @var integer
     */
    private $_page;
    
    /**
     * Общее кол-во страниц
     * 
     * @var integer
     */
    private $_allPages;
    
    /**
     * @var boolean
     */
    private $_dotsLeft = FALSE;
    
    private $_dotsRight = FALSE;
    
    private $_pageStart;
    
    private $_pageEnd;
    
    //-----------------------------------------------------------------------------------------------------------
    
    /**
     * {@inheritDoc}
     * @see LitePager::init()
     */
    public function init()
    {
        $this->appendSeo();
        $this->setLinks();

        parent::init();
        
        $this->_pageIndex = $this->currentPage;
        $this->_page      = $this->_pageIndex + 1;
        $this->_allPages  = $this->getPageCount();
    }
    
    /**
     * Данные по пагинации для парсера
     * 
     * @return array
     */
    private function _getPagesData()
    {
        $buttons = [];
        
        $buttons[] = $this->createPageButton($this->prevPageLabel, $this->_pageIndex - 1, $this->previousPageCssClass, !$this->showPrevNext || $this->_page <= 1, FAlSE);
        
        $buttons[] = $this->createPageButton(self::PAGE_FIRST, NULL, $this->internalPageCssClass, FALSE, self::PAGE_FIRST == $this->_page);
        
        if ($this->_dotsLeft)
        {
            $buttons[] = $this->dotsLabel;
        }
        
        for ($i = $this->_pageStart; $i <= $this->_pageEnd; $i++)
        {
            $buttons[] = $this->createPageButton($i, $i - 1, $this->internalPageCssClass, FALSE, $i == $this->_page);
        }
        
        if ($this->_dotsRight)
        {
            $buttons[] = $this->dotsLabel;
        }
        
        $buttons[] = $this->createPageButton($this->_allPages, $this->_allPages - 1, $this->internalPageCssClass, FALSE, $this->_allPages == $this->_page);
        
        $buttons[] = $this->createPageButton($this->nextPageLabel, $this->_page, $this->nextPageCssClass, !$this->showPrevNext || $this->_page == $this->_allPages, FALSE);
        
        return $buttons;
    }
    
    /**
     * {@inheritDoc}
     * @see LitePager::createPageButtons()
     */
    protected function createPageButtons()
    {   
        
        if (is_double($resultDivision = $this->showButtonCount / 2))
        {
            $halfLeft = $halfRight = floor($resultDivision);
        }
        else
        {
            $halfLeft  = $resultDivision - 1;
            $halfRight = $resultDivision;
        }
        
        if (self::PAGE_FIRST + $this->_page - $halfLeft > $this->showButtonCount)
        {
            $this->_dotsLeft = TRUE;
        
            if ($this->_allPages - ($this->_page + $halfRight) < 2)
            {
                $this->_pageStart = $this->_allPages - $this->showButtonCount;
        
                $this->_pageEnd = $this->_allPages - 1;
        
            }
            else
            {
                $this->_dotsRight = TRUE;
                $this->_pageStart = $this->_page - $halfLeft;
                $this->_pageEnd   = $this->_page + $halfRight;
            }
        }
        else
        {
            $this->_pageStart = self::PAGE_FIRST + 1;
            $this->_pageEnd   = $this->showButtonCount + 1;
        
            if ($this->_allPages - ($this->_page + $halfRight) >= $this->showButtonCount)
            {
                $this->_dotsRight = TRUE;
            }
        }
        
        return $this->_getPagesData();
    }

}