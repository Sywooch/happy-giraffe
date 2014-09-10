<?php
/**
 * @var $model Horoscope
 */
$model->calculateMonthDays();
?>
<div class="horoscope-monce">
    <div class="horoscope-monce_hold">
        <div class="ico-zodiac ico-zodiac__l">
            <div class="ico-zodiac_in ico-zodiac__<?= $model->zodiac ?>"></div>
        </div>
        <div class="b-calendar">
            <div class="b-calendar_in b-calendar_in__years">
                <div class="b-calendar_t">Год</div>
                <ul class="b-calendar_ul">
                    <li class="b-calendar_li"><a href="#" class="b-calendar_a">2011</a></li>
                    <li class="b-calendar_li"><a href="#" class="b-calendar_a">2012</a></li>
                    <li class="b-calendar_li"><a href="#" class="b-calendar_a">2013</a></li>
                    <li class="b-calendar_li active"><a href="#" class="b-calendar_a">2014</a></li>
                </ul>
            </div>
            <div class="b-calendar_in b-calendar_in__months">
                <div class="b-calendar_t">Месяц</div>
                <ul class="b-calendar_ul">
                    <li class="b-calendar_li"><a href="#" class="b-calendar_a">янв</a></li>
                    <li class="b-calendar_li"><a href="#" class="b-calendar_a">фев</a></li>
                    <li class="b-calendar_li"><a href="#" class="b-calendar_a">мар</a></li>
                    <li class="b-calendar_li"><a href="#" class="b-calendar_a">апр</a></li>
                    <li class="b-calendar_li"><a href="#" class="b-calendar_a">май</a></li>
                    <li class="b-calendar_li"><a href="#" class="b-calendar_a">июн</a></li>
                    <li class="b-calendar_li"><a href="#" class="b-calendar_a">июл</a></li>
                    <li class="b-calendar_li active"><a href="#" class="b-calendar_a">авг</a></li>
                    <li class="b-calendar_li"><span class="b-calendar_a">сен</span></li>
                    <li class="b-calendar_li"><span class="b-calendar_a">окт</span></li>
                    <li class="b-calendar_li"><span class="b-calendar_a">ноя</span></li>
                    <li class="b-calendar_li"><span class="b-calendar_a">дек</span></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="wysiwyg-content clearfix">
        <?= Str::strToParagraph($model->text) ?>
    </div>
    <div class="b-calendar">
        <div class="b-calendar_in b-calendar_in__days-type">
            <?php $this->beginWidget('SeoContentWidget'); ?>
            <ul class="b-calendar_ul">
                <?php
                $daysInMonth = date("t", mktime(0, 0, 0, (int) $model->month, 1, (int) $model->year)); // узнаем число дней в месяце
                $skip = date("w", mktime(0, 0, 0, (int) $model->month, 1, (int) $model->year)) - 1; // узнаем номер первого дня недели
                if ($skip == -1)
                    $skip = 6;

                for ($day = - $skip; $day < $daysInMonth; $day++)
                {
                    if ($day < 0)
                        echo CHtml::tag('li', array('class' => 'b-calendar_li'), CHtml::tag('span', array('class' => 'b-calendar_a'), '&nbsp;'));
                    else
                        echo CHtml::tag('li', array('class' => 'b-calendar_li' . ($model->GetDayData($day) ? ' b-calendar_li__' . $model->GetDayData($day) : '')), CHtml::link($day + 1, '#', array('class' => 'b-calendar_a')));
                }
                ?>
            </ul>
            <?php $this->endWidget(); ?>
        </div>
        <div class="b-calendar_day-type">
            <div class="b-calendar_day-type-row">
                <div class="b-calendar_day-good"></div><span class="color-gray">&nbsp; - &nbsp; благоприятные дни</span>
            </div>
            <div class="b-calendar_day-type-row">
                <div class="b-calendar_day-bad"></div><span class="color-gray">&nbsp; - &nbsp; неблагоприятные дни</span>
            </div>
        </div>
    </div>
</div>