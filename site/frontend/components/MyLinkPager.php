<?php
Yii::import('system.web.widgets.pagers.CLinkPager');
class MyLinkPager extends CLinkPager
{
    public $cssFile = false;
    public $firstPageLabel = '';
    public $lastPageLabel = '';
    public $nextPageLabel = '';
    public $prevPageLabel = '';

    /**
     * Creates a page button.
     * You may override this method to customize the page buttons.
     *
     * @param string  $label the text label for the button
     * @param integer $page the page number
     * @param string  $class the CSS class for the page button. This could be 'page', 'first', 'last', 'next' or 'previous'.
     * @param boolean $hidden whether this page button is visible
     * @param boolean $selected whether this page button is selected
     *
     * @return string the generated button
     */
    protected function createPageButton($label, $page, $class, $hidden, $selected)
    {
        if ($hidden || $selected)
            $class .= ' ' . ($hidden ? self::CSS_HIDDEN_PAGE : self::CSS_SELECTED_PAGE);
        return '<li class="' . $class . '">' . CHtml::link(CHtml::tag('span', array(), $label), $this->createPageUrl($page)) . '</li>';
    }
}
