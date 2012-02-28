<?php
/* @var $this Controller
 * @var $form CActiveForm
 */
$year = date('Y');
$model = new ChinaCalendarForm();
$js = <<<EOD
    var arr = new Array(
        new Array(2, 1, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1),
        new Array(1, 2, 1, 2, 2, 1, 1, 2, 1, 1, 2, 2),
        new Array(2, 1, 2, 1, 1, 1, 1, 1, 1, 2, 1, 1),
        new Array(1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2),
        new Array(2, 1, 1, 2, 1, 2, 2, 1, 2, 2, 2, 2),
        new Array(1, 1, 1, 2, 1, 1, 2, 2, 2, 1, 1, 2),
        new Array(1, 2, 2, 1, 1, 2, 1, 2, 1, 1, 2, 1),
        new Array(2, 1, 2, 1, 2, 1, 2, 1, 2, 1, 1, 1),
        new Array(1, 1, 1, 1, 1, 2, 1, 2, 2, 1, 2, 2),
        new Array(2, 2, 1, 1, 2, 1, 2, 2, 1, 2, 1, 1),
        new Array(1, 1, 1, 2, 2, 1, 2, 1, 2, 2, 1, 2),
        new Array(2, 1, 2, 2, 1, 2, 2, 1, 2, 1, 2, 2),
        new Array(1, 1, 2, 1, 2, 1, 1, 1, 1, 1, 1, 1),
        new Array(1, 1, 1, 1, 2, 2, 1, 2, 1, 2, 2, 2),
        new Array(1, 2, 2, 1, 2, 1, 1, 2, 1, 1, 2, 1),
        new Array(2, 1, 1, 2, 2, 1, 2, 1, 2, 1, 1, 2),
        new Array(1, 1, 2, 2, 1, 2, 1, 1, 2, 1, 2, 2),
        new Array(1, 2, 1, 2, 1, 2, 1, 2, 1, 1, 2, 1),
        new Array(1, 2, 1, 1, 1, 2, 1, 1, 2, 2, 2, 2),
        new Array(2, 2, 1, 2, 2, 2, 1, 2, 2, 1, 1, 1),
        new Array(1, 1, 2, 2, 1, 2, 2, 1, 2, 2, 1, 2),
        new Array(2, 2, 1, 2, 2, 2, 1, 2, 1, 1, 2, 1),
        new Array(1, 1, 1, 2, 1, 2, 1, 2, 1, 2, 2, 1),
        new Array(2, 2, 1, 2, 1, 1, 2, 2, 1, 2, 1, 2),
        new Array(1, 2, 2, 1, 1, 1, 1, 1, 2, 1, 2, 1),
        new Array(2, 1, 2, 2, 1, 1, 1, 2, 2, 2, 1, 1),
        new Array(1, 2, 2, 2, 1, 2, 1, 1, 2, 1, 2, 1),
        new Array(2, 1, 2, 1, 2, 2, 1, 2, 1, 2, 1, 2)
    );
    var year = null;

    $(document).ready(function () {
        var d = new Date();
        year = d.getFullYear();

        $('.calc_bt').click(function () {
            var d = new Date();
            var baby_y = parseInt($('#child_yr_cal').val());
            var mother_m = parseInt($('#mam_mn_cal').val());
            var baby_m = parseInt($('#ch_mn_cal').val());
            var mother_y = parseInt($('#mam_yr_cal').val());
            year = baby_y;

            var age = baby_y - mother_y;
            if (baby_m <= mother_m)
                var age = baby_y - mother_y - 1;
            if (age < 18 || age > 45) {
                $('#china-calendar-result').html('');
                $('.wh_wait').hide();
                return false;
            }

            ShowCalendar();

            var gender = GetGenderFromAge(age, baby_m);
            $('.wh_wait').hide();
            if (gender == 1) {
                $('.wh_son').show();
            }
            if (gender == 2) {
                $('.wh_daughter').show();
            }

            return false;
        });

        $('body').delegate('#prev', 'click', function () {
            var mother_y = $('#mam_yr_cal').val();
            var age = year - mother_y - 1;
            if (age < 18 || (age == 18 && $('#mam_mn_cal').val() == 12))
                return false;
            year--;
            ShowCalendar();
            if (age == 18 || (age == 19 && $('#mam_mn_cal').val() == 12))
                $('#prev').addClass('disabled');

            return false;
        });

        $('body').delegate('#next', 'click', function () {
            var mother_y = $('#mam_yr_cal').val();
            var age = year - mother_y;
            if (age > 45)
                return false;

            year++;
            ShowCalendar();
            if (age == 45)
                $('#next').addClass('disabled');

            return false;
        });
    });

    function ShowCalendar() {
        var calendar2_html = '<div class="month_calendar"><div class="choice_month">' +
            '<a href="#" id="prev" class="prev">&larr;</a>' +
            '<a href="#" id="next"  class="next">&rarr;</a>' +
            '<span>' + year + '</span>' +
            '</div><table class="calendar_body"><tr><th>Янв</th><th>Фев</th><th>Мар</th><th>Апр</th><th>Май</th>' +
            '<th>Июн</th><th>Июл</th><th>Авг</th><th>Сен</th><th>Окт</th><th>Ноя</th><th>Дек</th></tr><tr>';

        //calc mother age
        var mother_m = parseInt($('#mam_mn_cal').val());
        var mother_y = parseInt($('#mam_yr_cal').val());

        for (var i = 1; i <= 12; i++) {
            var age = year - mother_y;
            if (i <= mother_m)
                var age = year - mother_y - 1;

            var gender = GetGenderFromAge(age, i);
            var cell_class = '';
            if (gender == 1)
                cell_class = "cal_item boy_day";
            if (gender == 2)
                cell_class = "cal_item girl_day";
            if (year == $('#child_yr_cal').val() && i == $('#ch_mn_cal').val())
                cell_class += ' active_item';

            calendar2_html += "<td><div class='" + cell_class + "'><i class='icon'></i></div></td>";
        }
        calendar2_html += '</tr></table></div>';
        $('#china-calendar-result').html(calendar2_html);
    }

    function GetGenderFromAge(age, month) {
        if (age - 18 < 0)
            return 0;
        if (age - 45 > 0)
            return 0;
        var result = arr[age - 18][month - 1];
        return result;
    }
EOD;
Yii::app()->clientScript->registerScript('baby-sex-china',$js);
?>

<div class="child_sex_china_banner">
    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'china-calendar-form',
    'enableAjaxValidation' => false,
));?>
    <div class="mam_bd">
        <span class="title_pt_bn">Месяц и год рождения матери:</span>
        <ul class="lists_td">
            <li>
                <?php echo $form->dropDownList($model, 'mother_m', HDate::ruMonths(), array('id' => 'mam_mn_cal', 'class' => 'chzn')); ?>
            </li>
            <li>
                <?php echo $form->dropDownList($model, 'mother_y', HDate::Range($year - 46, $year - 18), array('id' => 'mam_yr_cal', 'class' => 'chzn')); ?>
            </li>
        </ul>
    </div>
    <!-- .mam_bd -->
    <div class="child_bd">
        <span class="title_pt_bn"><ins>Месяц и год зачатия ребенка:</ins></span>
        <ul class="lists_td">
            <li>
                <?php echo $form->dropDownList($model, 'baby_m', HDate::ruMonths(), array('id' => 'ch_mn_cal', 'class' => 'chzn')); ?>
            </li>
            <li>
                <?php echo $form->dropDownList($model, 'baby_y', HDate::Range($year - 10, $year + 20), array('id' => 'child_yr_cal', 'class' => 'chzn')); ?>
            </li>
        </ul>
    </div>
    <!-- .child_bd -->
    <?php echo $form->hiddenField($model, 'review_year', array('id' => 'china_review_year')) ?>
    <input type="button" class="calc_bt" value="Рассчитать"/>
    <?php $this->endWidget(); ?>
</div><!-- .child_sex_china_banner -->

<div id="china-calendar-result">

</div>
<div class="clear"></div>

<div class="wh_wait wh_daughter" style="display: none;">
    <div class="img-box">
        <img src="/images/baby_girl.jpg">
    </div>
    <div class="text">
    <span class="title_wh_wait">Поздравляем! У вас будет девочка!</span>

    <p>ООб этом говорит древнекитайская таблица, точность результатов которой составляет 60%. Конечно, надо понимать,
        что это не 100%-я гарантия рождения девочки.</p>
</div></div>
<div class="wh_wait wh_son" style="display: none;">
    <div class="img-box">
        <img src="/images/baby_boy.jpg">
    </div>
    <div class="text">
    <span class="title_wh_wait">Поздравляем! У вас будет мальчик!</span>

    <p>Так получается, исходя из данных древнекитайской таблицы. Её точность составляет 60%, она не даёт гарантии
        рождения мальчика, но почему бы и не попробовать?</p>
</div></div>

<div class="seo-text">
    <div class="summary-title">Китайский метод определения</div>
    <p>По мнению китайских мудрецов, узнать пол будущего малыша можно по возрасту женщины на момент зачатия. Исходя из
        того, что в Китае семья может иметь только одного малыша и малыш, соответственно, должен быть желаемого пола,
        эффективность данного метода должна быть достаточно высокой. Именно поэтому все большее число пар планирует
        ребенка по китайскому методу.</p>

    <p>Например, мама 23 лет, которая забеременела зимой или осенью, вероятнее всего родит мальчика, а если зачатие
        случилось весной – то девочку. У мамы 22 лет ситуация кардинально меняется с точностью до наоборот.</p>

    <p>Древнекитайскую таблицу по планированию пола будущего малыша без проблем можно найти, но, скажем честно, она
        довольно-таки запутанная.</p>

    <p>Однако мы разобрались во всех нюансах этого метода, а наши программисты заложили эти знания в автоматическую
        систему. Так что китайским методом вы сможете легко воспользоваться – просто ответьте на вопросы системы.</p>

    <p>Исходя из того, что данный метод, по мнению современных медиков, «работает» на 60%, можно попробовать – а вдруг
        получится!</p>
</div>