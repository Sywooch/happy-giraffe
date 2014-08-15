<?php
/**
 * @var CDataProvider $dp
 * @var int $year
 * @var int $month
 * @var int $day
 * @var LiteController $this
 */
Yii::app()->clientScript->registerPackage('lite_contentCalendar');

function gavno($year, $m, $day)
{
    $d1 = strtotime(implode('-', array($year, $m, $day)));
    return $d1 < time() && $d1 > strtotime('2011-11-04');
}
?>

<div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
        <div class="b-main_col-article">
            <h1 class="heading-link-xxl"><?=$this->pageTitle?></h1>
        </div>
    </div>
    <div class="b-calendar">
        <div class="b-calendar_in b-calendar_in__years">
            <div class="b-calendar_t">Год</div>
            <?php $this->widget('zii.widgets.CMenu', array(
                'items' => array_map(function($y) use ($year, $month, $day) {
                    return array(
                        'label' => $y,
                        'url' => array('/blog/archive/index', 'year' => $y, 'month' => $month, 'day' => $day),
                        'linkOptions' => array('class' => 'b-calendar_a'),

                    );
                }, range(2011, 2014)),
                'htmlOptions' => array('class' => 'b-calendar_ul'),
                'itemCssClass' => 'b-calendar_li',
            )); ?>
        </div>
        <div class="b-calendar_in b-calendar_in__months">
            <div class="b-calendar_t">Месяц</div>
            <?php $this->widget('zii.widgets.CMenu', array(
                'items' => array_map(function($m) use ($year, $month, $day) {
                    return array(
                        'label' => HDate::ruMonthShort($m),
                        'url' => gavno($year, $m, $day) ? array('/blog/archive/index', 'year' => $year, 'month' => $m, 'day' => $day) : null,
                        'linkOptions' => array('class' => 'b-calendar_a'),
                    );
                }, range(1, 12)),
                'htmlOptions' => array('class' => 'b-calendar_ul'),
                'itemCssClass' => 'b-calendar_li',
            )); ?>
        </div>
        <div class="b-calendar_in b-calendar_in__days">
            <div class="b-calendar_t">День</div>
            <?php $this->widget('zii.widgets.CMenu', array(
                'items' => array_map(function($d) use ($year, $month, $day) {
                    return array(
                        'label' => $d,
                        'url' => gavno($year, $month, $d) ? array('/blog/archive/index', 'year' => $year, 'month' => $month, 'day' => $d) : null,
                        'linkOptions' => array('class' => 'b-calendar_a'),
                    );
                }, range(1, cal_days_in_month(CAL_GREGORIAN, $month, $year))),
                'htmlOptions' => array('class' => 'b-calendar_ul'),
                'itemCssClass' => 'b-calendar_li',
            )); ?>
        </div>
    </div>
    <div class="post-list-simple">
        <?php $this->widget('LiteListView', array(
            'dataProvider' => $dp,
            'itemView' => '_content',
            'emptyText' => 'Нет ни одной записи по вашему запросу',
        )); ?>
    </div>
</div>