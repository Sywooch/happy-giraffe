<?php
/**
 * Author: alexk984
 * Date: 27.09.12
 */
class PromotionHelper
{
    private static $_instance;

    private $_innerLinks = null;
    private $_positions = array();

    public static function model()
    {
        if (!self::$_instance)
            self::$_instance = new PromotionHelper();

        return self::$_instance;
    }

    public function getInnerLinksCount($phrase_id)
    {
        if ($this->_innerLinks === null)
            $this->loadInnerLinks();

        $k = 0;
        foreach ($this->_innerLinks as $link)
            if ($link == $phrase_id)
                $k++;

        return $k;
    }

    public function loadInnerLinks()
    {
        $this->_innerLinks = Yii::app()->db_seo->createCommand()
            ->select('phrase_id')
            ->from(InnerLink::model()->tableName())
            ->queryColumn();
    }

    /**
     * @param $pages Page[]
     */
    public function loadPositions($pages)
    {
        $phrase_ids = array();
        foreach ($pages as $page)
            $phrase_ids = array_merge($phrase_ids, CHtml::listData($page->phrases, 'id', 'id'));

        if (empty($phrase_ids))
            $this->_positions = array();

        $positions = Yii::app()->db_seo->createCommand()
            ->select('*')
            ->from(SearchPhrasePosition::model()->tableName())
            ->where('search_phrase_id IN (' . implode(',', $phrase_ids) . ')')
            ->queryAll();

        foreach ($phrase_ids as $phrase_id) {
            $this->_positions[$phrase_id] = array();
            foreach ($positions as $key => $position) {
                if ($position['search_phrase_id'] == $phrase_id) {
                    $position['date'] = strtotime($position['date']);
                    $this->_positions[$phrase_id][] = $position;
                    unset($position[$key]);
                }
            }

            usort($this->_positions[$phrase_id], array('PromotionHelper', 'cmp'));
        }
    }

    static function cmp($a, $b)
    {
        if ($a == $b) {
            return 0;
        }
        return ($a > $b) ? -1 : 1;
    }

    public function getPosition($phrase_id, $se)
    {
        foreach ($this->_positions[$phrase_id] as $pos)
            if ($pos['se_id'] == $se)
                return $pos['position'];

        return 0;
    }

    public function getPositionView($phrase_id, $se)
    {
        $last_pos = null;
        $prev_pos = null;
        foreach ($this->_positions[$phrase_id] as $pos)
            if ($pos['se_id'] == $se) {
                if ($last_pos !== null){
                    $prev_pos = $pos['position'];
                    break;
                }
                $last_pos = $pos['position'];
            }

        if ($last_pos == null)
            return '> 100';
        if ($prev_pos == null)
            return $last_pos;

        if ($last_pos < $prev_pos)
            return $this->showPosition($last_pos) . ' <i class="icon-up"></i> ' . '<a onmouseover="SeoLinking.showPositions(this, ' . $se . ', ' . $phrase_id . ')" href="javascript:;">' . $prev_pos . '</a>';
        elseif ($last_pos > $prev_pos)
            return $this->showPosition($last_pos) . ' <i class="icon-down"></i> ' . '<a onmouseover="SeoLinking.showPositions(this, ' . $se . ', ' . $phrase_id . ')" href="javascript:;">' . $prev_pos . '</a>';


        return '<a onmouseover="SeoLinking.showPositions(this, ' . $se . ', ' . $phrase_id . ')" href="javascript:;">' . $this->showPosition($last_pos) . '</a>';
    }

    public function showPosition($position)
    {
        if ($position >= 1000)
            return '> 100';

        return $position;
    }
}