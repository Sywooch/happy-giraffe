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
                    <?php
                    $models = Horoscope::model()->findAll(array(
                        'condition' => '`year` IS NOT NULL AND `month` IS NULL AND `zodiac` = :z',
                        'order' => '`year`',
                        'params' => array(
                            ':z' => $model->zodiac,
                        )
                    ));
                    $models = CHtml::listData($models, 'year', 'year');
                    foreach ($models as $year)
                        // Экономим один запрос к бд, за счёт хардкода мая 2012 года. Это самый первый гороскоп.
                        // Для остальных годов отправляем на январь выбранного года
                        echo CHtml::tag('li', array('class' => 'b-calendar_li' . ($year == $model->year ? ' active' : '')), CHtml::link($year, $this->getUrl(array('period' => 'month', 'date' => mktime(0, 0, 0, $year == 2012 ? 5 : 1, 1, (int) $year))), array('class' => 'b-calendar_a')));
                    ?>
                </ul>
            </div>
            <div class="b-calendar_in b-calendar_in__months">
                <div class="b-calendar_t">Месяц</div>
                <ul class="b-calendar_ul">
                    <?php
                    $models = Horoscope::model()->findAll(array(
                        'condition' => '`year` = :y AND `month` IS NOT NULL AND `zodiac` = :z',
                        'params' => array(
                            ':y' => $model->year,
                            ':z' => $model->zodiac,
                        )
                    ));
                    $models = CHtml::listData($models, 'month', 'month');
                    for ($i = 1; $i < 13; $i++)
                        if (isset($models[$i]))
                            echo CHtml::tag('li', array('class' => 'b-calendar_li' . ($i == $model->month ? ' active' : '')), CHtml::link(HDate::ruMonthShort($i), $this->getUrl(array('period' => 'month', 'date' => mktime(0, 0, 0, $i, 1, (int) $model->year))), array('class' => 'b-calendar_a')));
                        else
                            echo CHtml::tag('li', array('class' => 'b-calendar_li'), CHtml::tag('span', array('class' => 'b-calendar_a'), HDate::ruMonthShort($i)));
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="wysiwyg-content clearfix">
        <?= Str::strToParagraph($model->text) ?>
    </div>
    <div class="b-calendar">
        <div class="b-calendar_in b-calendar_in__days-type">
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
                        echo CHtml::tag('li', array('class' => 'b-calendar_li' . ($model->GetDayData($day) ? ' b-calendar_li__' . $model->GetDayData($day) : '')), CHtml::link($day + 1, $this->getUrl(array('period' => 'day', 'date' => mktime(0, 0, 0, (int) $model->month, $day + 1, (int) $model->year))), array('class' => 'b-calendar_a')));
                }
                ?>
            </ul>
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