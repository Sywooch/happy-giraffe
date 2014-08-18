<?php
/**
 * @var CDataProvider $dp
 * @var int $year
 * @var int $month
 * @var int $day
 * @var LiteController $this
 * @var string $h1
 */
?>

<div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
        <div class="b-main_col-article">
            <h1 class="heading-link-xxl"><?=$h1?></h1>
        </div>
    </div>
    <div class="b-calendar">
        <div class="b-calendar_in b-calendar_in__years">
            <div class="b-calendar_t">Год</div>
            <?php $this->widget('site\frontend\modules\archive\components\Menu', array(
                'items' => array_map(function($y) use ($year, $month, $day) {
                    return array(
                        'label' => $y,
                        'url' => array('/archive/default/index', 'year' => $y, 'month' => $month, 'day' => $day),
                        'linkOptions' => array('class' => 'b-calendar_a'),

                    );
                }, range(2011, 2014)),
            )); ?>
        </div>
        <div class="b-calendar_in b-calendar_in__months">
            <div class="b-calendar_t">Месяц</div>
            <?php $this->widget('site\frontend\modules\archive\components\Menu', array(
                'items' => array_map(function($m) use ($year, $month, $day) {
                    return array(
                        'label' => HDate::ruMonthShort($m),
                        'url' => site\frontend\modules\archive\components\MenuHelper::isActiveMonth($year, $m) ? array('/archive/default/index', 'year' => $year, 'month' => $m, 'day' => $day) : null,
                        'linkOptions' => array('class' => 'b-calendar_a'),
                    );
                }, range(1, 12)),
            )); ?>
        </div>
        <div class="b-calendar_in b-calendar_in__days">
            <div class="b-calendar_t">День</div>
            <?php $this->widget('site\frontend\modules\archive\components\Menu', array(
                'items' => array_map(function($d) use ($year, $month, $day) {
                    return array(
                        'label' => $d,
                        'url' => site\frontend\modules\archive\components\MenuHelper::isActiveDay($year, $month, $d) ? array('/archive/default/index', 'year' => $year, 'month' => $month, 'day' => $d) : null,
                        'linkOptions' => array('class' => 'b-calendar_a'),
                    );
                }, range(1, cal_days_in_month(CAL_GREGORIAN, $month, $year))),
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