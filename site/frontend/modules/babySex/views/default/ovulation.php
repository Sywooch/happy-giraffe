<?php
/**
 * @var $form CActiveForm
 */
$model = new OvulationForm();
?>
<style type="text/css">
    .baby-1{
        background: #0babd9;
    }
    .baby-2{
        background: #d920bd;
    }
    .baby-3{
        background: #d9122a;
    }
</style>
<script type="text/javascript">
    var started = false;

    $(function () {
        $('#ovulation-form input.mth_calculate').click(function () {
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

<div class="mother_cal_banner">
    <span>Менструальный цикл – это биологические часы женщины, запущенные самой природой. Составьте свой женский календарь и проверьте – правильно ли идут ваши часы, а также узнайте массу другой полезной информации.</span>
</div><!-- .mother_cal_banner -->
<div class="calculate_tb">
    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'ovulation-form',
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
            $skip = date("w")-1;
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
</div>