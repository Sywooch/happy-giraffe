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
        return [
            'label' => $title . \CHtml::tag('span', ['class' => 'questions-categories_count'], $count),
            'url' => $url,
            'linkOptions' => ['class' => 'questions-categories_link'],
        ];

    }
}