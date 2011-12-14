<?php
/**
 * @var $form CActiveForm
 */
$model = new MenstrualCycleForm();?>
<script type="text/javascript">
    var started = false;

    $(function () {
        $('#menstrual-cycle-form input.mth_calculate').click(function () {
            var d = new Date();
            $('#review_month').val($('#mn_cal').val());
            $('#review_year').val($('#yr_cal').val());
            LoadCalendar();
            return false;
        });

        $('body').delegate('div.choice_month a#next-month', 'click', function () {
            var month = $('#review_month').val();
            if (month == '')
                return false;
            var year = $('#review_year').val();

            month++;
            if (month == 13) {
                month = 1;
                year++;
                $('#review_year').val(year);
            }
            $('#review_month').val(month);
            LoadCalendar();
            return false;
        });

        $('body').delegate('div.choice_month a#prev-month', 'click', function () {
            var month = $('#review_month').val();
            if (month == '')
                return false;
            var year = $('#review_year').val();

//            var d = new Date();
//            if (month == d.getMonth() + 1 && year == d.getFullYear())
//                return false;

            month--;
            if (month == 0) {
                month = 12;
                year--;
                $('#review_year').val(year);
            }

            $('#review_month').val(month);
            LoadCalendar();
            return false;
        });

        $('body').delegate('.cal_item', 'hover', function (event) {
            if (event.type == 'mouseenter') {
                $(this).find('.hint').stop(true, true).fadeIn();
            } else {
                $(this).find('.hint').stop(true, true).fadeOut();
            }
        });
        $('body').delegate('.cal_item_default', 'hover', function (event) {
            if (event.type == 'mouseenter') {
                $(this).find('.hint').stop(true, true).fadeIn();
            } else {
                $(this).find('.hint').stop(true, true).fadeOut();
            }
        });

        function LoadCalendar() {
            $.ajax({
                url:"<?php echo Yii::app()->createUrl("/menstrualCycle/default/calculate") ?>",
                data:$("#menstrual-cycle-form").serialize(),
                type:"POST",
                success:function (data) {
//                    $('#result').html(data);
                    $('#result').animate({opacity:0}, 'fast', 'swing', function () {
                        $('#result').html(data);
                        $('#result').animate({opacity:1}, 'fast');
                    });

//                    $('#result2').html(data);
//                    $('#result > .mother_calendar .calendar_body').animate({opacity:0}, 'fast', 'swing', function () {
//                        $('#result > .mother_calendar .calendar_body').html($('#result2 > .mother_calendar .calendar_body').html());
//                        $('#result > .mother_calendar .calendar_body').animate({opacity:1}, 'fast', 'swing');
//                    });
//                    if (started) {
//                        $('#result > .mother_calendar .choice_month span').animate({opacity:0}, 'fast', 'swing', function () {
//                            $('#result > .mother_calendar .choice_month span').html($('#result2 > .mother_calendar .choice_month span').html());
//                            $('#result > .mother_calendar .choice_month span').animate({opacity:1}, 'fast');
//                        });
//                    }
//                    if (started) {
//                        $('#next-m .next_month_cal .mother_calendar').animate({opacity:0}, 300, 'swing', function () {
//                            $('#next-m .next_month_cal .mother_calendar').html($('#result2 .next_month_cal .mother_calendar').html());
//                            $('#next-m .next_month_cal .mother_calendar').animate({opacity:1}, 300);
//                        });
//                    }
//                    else {
//                        $('#next-m').animate({opacity:0}, 1, 'swing', function () {
//                            $('#next-m').html($('#result2 .bottom-wrap').html());
//                            $('#next-m').animate({opacity:1}, 300);
//                        });
//                        started = true;
//                    }
                }
            });
        }
    });
</script>

<div class="mother_cal_banner">
    <span>Менструальный цикл – это биологические часы женщины, запущенные самой природой. Составьте свой женский календарь и проверьте – правильно ли идут ваши часы, а также узнайте массу другой полезной информации.</span>
</div><!-- .mother_cal_banner -->
<div class="calculate_tb">
    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'menstrual-cycle-form',
    'enableAjaxValidation' => false,
));
    echo $form->hiddenField($model, 'review_month', array('id' => 'review_month'));
    echo $form->hiddenField($model, 'review_year', array('id' => 'review_year'));?>
    <table>
        <tr>
            <th>День первого дня<br/>менструации предыдущего цикла:</th>
            <th>Длительность<br/> цикла</th>
            <th>Длительность<br/> менструации</th>
        </tr>
        <tr>
            <td>
                <ul class="lists_td">
                    <li>
                        <?php echo $form->dropDownList($model, 'day', HDate::Days(), array('id' => 'num_cal', 'class' => 'num_cal')); ?>
                    </li>
                    <li>
                        <?php echo $form->dropDownList($model, 'month', HDate::ruMonths(), array('id' => 'mn_cal', 'class' => 'mn_cal')); ?>
                    </li>
                    <li>
                        <?php echo $form->dropDownList($model, 'year', HDate::Range(date('Y') - 1, date('Y')), array('id' => 'yr_cal', 'class' => 'yr_cal')); ?>
                    </li>
                </ul>
            </td>
            <td>
                <?php echo $form->dropDownList($model, 'cycle', HDate::Range(21, 35), array('id' => 'cl_cal', 'class' => 'num_cal')); ?>
            </td>
            <td>
                <?php echo $form->dropDownList($model, 'critical_period', HDate::Range(3, 7), array('id' => 'men_cal', 'class' => 'num_cal')); ?>
            </td>
        </tr>
    </table>
    <input type="button" class="mth_calculate" value="Рассчитать"/>
    <?php $this->endWidget(); ?>
    <div class="clear"></div>
    <!-- .clear -->
</div><!-- .calculate_tb -->
<div id="result">
    <div class="mother_calendar">
        <div class="choice_month">
            <a href="#" class="l_arr_mth" id="prev-month">&larr;</a>
            <a href="#" class="r_arr_mth_active" id="next-month">&rarr;</a>
            <span><?php echo HDate::ruMonth(date('m')), ', ' . date('Y') ?></span>
        </div>
        <!-- .choice_month -->
        <table class="calendar_body">
            <tr>
                <th>Пн</th>
                <th>Вт</th>
                <th>Ср</th>
                <th>Чт</th>
                <th>Пт</th>
                <th>Сб</th>
                <th>Вс</th>
            </tr>
            <?php
            $skip = date("w");
            if ($skip < 0)
                $skip = 6;
            $daysInMonth = date("t");
            $day = 1;
            $calendar_body = '';
            for ($i = 0; $i < 6; $i++) { // Внешний цикл для недель 6 с неполыми

                $calendar_body .= '<tr>'; // открываем тэг строки
                for ($j = 0; $j < 7; $j++) { // Внутренний цикл для дней недели

                    if (($skip > 0)or($day > $daysInMonth)) { // выводим пустые ячейки до 1 го дня ип после полного количства дней
                        if ($day > $daysInMonth) {
                            $daysOtherMonth = date("t", strtotime('+1 month', strtotime(date("Y-m-d"))));
                            $day2 = $day - $daysInMonth;
                        } else {
                            $daysOtherMonth = date("t", strtotime('-1 month', strtotime(date("Y-m-d"))));
                            $day2 = $daysOtherMonth - $skip + 1;
                        }
                        $calendar_body .= ' <td><div class="cal_item_default"><div class="cal_item "><ins>' . $day2 . '</ins>' .
                            '</div></div></td>';
                        $skip--;

                    }
                    else {

                        $calendar_body .= '<td><div class="cal_item"><ins>' . $day . '</ins></div></td>';
                        $day++; // увеличиваем $day
                    }

                }
                $calendar_body .= '</tr>'; // закрываем тэг строки
                if ($day > $daysInMonth)
                    break;
            }
            echo $calendar_body;
            ?>
        </table>
    </div>
    <!-- .mother_calendar -->
    <div id="next-m"></div>
</div>
<div class="seo-text">
    <span class="summary-title">Менструальный цикл – жизнь по расписанию</span>

    <p>Менструальный цикл &ndash; это не просто кровотечение по расписанию, это перестройка всего организма с одной
        единственной целью &ndash; дать начало новой человеческой жизни.</p>

    <p>Традиционно первым днём менструального цикла является начало менструации. В это время матка отторгает
        непригодившийся внутренний слой &ndash; эндометрий, освобождая место для роста нового.</p>

    <p>В это же время под контролем гипоталамуса в гипофизе вырабатываются гормоны, стимулирующие созревание яйцеклетки
        в яичнике женщины, начинает повышаться уровень женских половых гормонов &ndash; эстрогенов.</p>

    <p>После окончания менструации продолжает нарастать уровень эстрогенов, и к середине цикла он достигает максимума.
        Слизь, закрывающая канал шейки матки, становится жидкой, создавая условия для свободного проникновения в полость
        матки сперматозоидов, а созревшая яйцеклетка покидает фолликул яичника и отправляется навстречу сперматозоиду. В
        момент выхода яйцеклетки из яичника отмечается повышение температуры тела женщины примерно на полградуса.</p>

    <p>Если яйцеклетка не встретилась со сперматозоидом и беременность не состоялась, уровень эстрогенов резко
        снижается. Фолликул, который покинула яйцеклетка, становится жёлтым телом и начинает вырабатывать
        прогестерон.</p>

    <p>Через несколько дней жёлтое тело начинает уменьшаться в размерах, снижается его активность, параллельно
        уменьшается выработка прогестерона. В этот период у многих женщин развивается так называемый ПМС
        (предменструальный синдром), который проявляется резкой сменой настроения, раздражительностью, плаксивостью,
        депрессиями, появлением отёчности лица, нагрубанием молочных желез. Когда уровень прогестерона достигает
        минимума, температура тела женщины понижается на полградуса и начинается менструальное кровотечение, то есть
        следующий менструальный цикл.</p>

    <p>Длительность менструального цикла у каждой женщины своя &ndash; от 21 до 35 суток, но она постоянна. То есть если
        цикл составляет 28 дней в этом месяце, то и в следующем будет таким, и через полгода тоже. Многие женщины ведут
        календари, в которых отмечают начало и продолжительность каждой менструации.</p>

    <div class="brushed">
    <p style="margin-top:0;">Наш сервис предлагает завести себе электронный календарь, при помощи которого можно:</p>
    <ul>
        <li>составить индивидуальный график менструального цикла за любой промежуток времени (при этом все данные
            сохраняются, и их легко проанализировать);
        </li>
        <li>узнать вероятную дату овуляции;</li>
        <li>определить опасные и безопасные дни для наступления беременности;</li>
        <li>спрогнозировать начало ПМС и вовремя принять меры.</li>
    </ul>
    <p>Для этого нужно ввести все данные в специальные окошки. Нажать кнопку &laquo;рассчитать&raquo; и посмотреть
        результат, который наглядно покажет именно ваш менструальный цикл со всеми его особенностями, что, несомненно,
        поможет правильно спланировать свою личную жизнь. Кстати, вам не придётся повторять ввод данных &ndash; ваш
        женский календарь сохранится в вашем личном кабинете и будет постоянно доступен для пользования и занесения
        данных нового месяца.</p>
    </div>

</div><!-- .placenta_article -->
<div id="result2" style="display: none;"></div>