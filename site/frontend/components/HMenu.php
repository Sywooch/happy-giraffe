<?php
/**
 * Author: choo
 * Date: 27.06.2012
 */

Yii::import('zii.widgets.CMenu');

class HMenu extends CMenu
{
    public $seoHide = false;

    protected function renderMenuItem($item)
    {
        if(isset($item['url']))
        {
            $label=$this->linkLabelWrapper===null ? $item['label'] : '<'.$this->linkLabelWrapper.'>'.$item['label'].'</'.$this->linkLabelWrapper.'>';
            return ($this->seoHide) ?
                HHtml::link($label,$item['url'],isset($item['linkOptions']) ? $item['linkOptions'] : array(), true)
                :
                CHtml::link($label,$item['url'],isset($item['linkOptions']) ? $item['linkOptions'] : array());
        }
        else
            return CHtml::tag('span',isset($item['linkOptions']) ? $item['linkOptions'] : array(), $item['label']);
    }
}
