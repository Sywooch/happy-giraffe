<?php
/**
 * User: Eugene
 * Date: 30.03.12
 */

Yii::import('system.web.widgets.pagers.CLinkPager');
class AlbumLinkPager extends CLinkPager
{
    public $cssFile = false;
    public $firstPageLabel = '';
    public $lastPageLabel = '';
    public $nextPageLabel = '';
    public $prevPageLabel = '';
    public $header = '';

    protected function createPageButton($label, $page, $class, $hidden, $selected)
    {
        if ($hidden || $selected)
            $class .= ' ' . ($hidden ? self::CSS_HIDDEN_PAGE : self::CSS_SELECTED_PAGE);
        return '<li class="' . $class . '">' . CHtml::link($class == 'previous' || $class == 'next' ? '...' : $label, $this->createPageUrl($page), array('rel' => 'nofollow')) . ($selected ? '<img src="/images/pagination_tale.png">' : '') . '</li>';
    }
}
