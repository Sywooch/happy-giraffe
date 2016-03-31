<?php
/**
 * @author Никита
 * @date 12/11/15
 */

namespace site\frontend\modules\som\modules\qa\widgets;

\Yii::import('zii.widgets.CMenu');

abstract class SidebarMenu extends \CMenu
{
    public $htmlOptions = array(
        'class' => 'questions-categories_ul',
    );
    public $itemCssClass = 'questions-categories_li';
    public $encodeLabel = false;

    protected function getItem($title, $count, $url)
    {
        return array(
            'label' => $title . \CHtml::tag('span', array('class' => 'questions-categories_count'), $count),
            'url' => $url,
            'linkOptions' => array('class' => 'questions-categories_link'),
        );
    }
}