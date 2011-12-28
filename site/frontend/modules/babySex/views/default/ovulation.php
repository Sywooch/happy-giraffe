<?php
/**
 * @var $form CActiveForm
 */
$model = new OvulationForm();
?>
<script type="text/javascript">
    var started = false;

    $(function () {
        $('#ovulation-form input.calc_bt').click(function () {
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
                url:"<?php echo Yii::app()->createUrl("/babySex/default/OvulationCalc") ?>",
                data:$("#ovulation-form").serialize(),
                type:"POST",
                success:function (data) {
                    $('#result').html(data);
                }
            });
        }
    });
</script>
<div class="child_sex_ovulyaciya_banner">
    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'ovulation-form',
    'enableAjaxValidation' => false,
));
    echo $form->hiddenField($model, 'review_month', array('id' => 'review_month'));
    echo $form->hiddenField($model, 'review_year', array('id' => 'review_year'));?>
    <div class="dad_bd">
        <span class="title_pt_bn">Длительность цикла:</span>
        <ul class="lists_td">
            <li>
                <?php echo $form->dropDownList($model, 'cycle', HDate::Days(), array('id' => 'cl_cal', 'class' => 'num_cal')); ?>
            </li>
        </ul>
    </div>
    <!-- .dad_bd -->
    <div class="mam_bd">
        <span class="title_pt_bn">Дата первого дня менструации<br/> предыдущего цикла:</span>
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
    </div>
    <!-- .mam_bd -->
    <div class="child_bd">
        <span class="title_pt_bn"><ins>День зачатия ребенка:</ins></span>
        <ul class="lists_td">
            <li>
                <?php echo $form->dropDownList($model, 'con_day', HDate::Days(), array('id' => 'num_con', 'class' => 'num_cal')); ?>
            </li>
            <li>
                <?php echo $form->dropDownList($model, 'con_month', HDate::ruMonths(), array('id' => 'mn_con', 'class' => 'mn_cal')); ?>
            </li>
            <li>
                <?php echo $form->dropDownList($model, 'con_year', HDate::Range(date('Y') - 1, date('Y')), array('id' => 'yr_con', 'class' => 'yr_cal')); ?>
            </li>
        </ul>
    </div>
    <!-- .child_bd -->
    <input type="button" class="calc_bt" value="Рассчитать"/>
    <?php $this->endWidget(); ?>
</div><!-- .child_sex_banner -->

<div id="result">
    <div class="mother_calendar">
        <div class="choice_month">
            <a href="#" class="l_arr_mth" id="prev-month">&larr;</a>
            <a href="#" class="r_arr_mth" id="next-month">&rarr;</a>
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
            $skip = date("w") + 1;
            if ($skip > 6)
                $skip = 0;
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
</div>

<div class="seo-text">
    <div class="summary-title">Определение пола по овуляции</div>
    <p>Определение пола ребенка по дате овуляции - единственный более-менее достоверный способ. За основу метода взяты
        различия в размерах и поведении сперматозоидов, содержащих Х и Y-хромосомы, а также длительность жизни
        яйцеклетки.
        Точность метода зависит от того, насколько верно вы определили дату овуляции, поэтому будет лучше, если есть
        возможность взять усреднённые данные за 6 - 12 предыдущих циклов.</p>

    <p>Итак, вы вводите:</p>
    <ul>
        <li>дату начала менструации</li>
        <li>длительность менструации</li>
        <li>продолжительность менструального цикла</li>
    </ul>
    <p>Через несколько секунд вы получите результат и узнаете, кто же у вас появится – мальчик или девочка. Метод,
        конечно, не даёт 100% гарантии рождения ребёнка необходимого пола, однако он точнее прочих.</p>

    <p>Важно! Женщины, которым больше тридцати лет автоматически попадают в группу риска по рождению ребёнка с
        хромосомными аномалиями (болезнь Дауна, например). Однако многие учёные считают, что эти аномалии чаще
        возникают, когда яйцеклетка «стареет», то есть вышла из яичника сутки назад и больше. Наш сервис даёт
        возможность рассчитать дни повышенного риска для таких женщин. Обращайте внимание на специальные значки!</p>
</div>