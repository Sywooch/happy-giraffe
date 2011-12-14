<?php
/* @var $this Controller
 * @var $form CActiveForm
 */
$year = date('Y');
$model = new ChinaCalendarForm();
?>
<style type="text/css">
    input {
        border: 1px solid #000;
    }

    table td.boy {
        background: #0babd9;
    }

    table td.girl {
        background: #d921cc;
    }

    table.calendar-table {
        border-collapse: separate;
        border-spacing: 5px;
    }

    .sex-test-table-boy div {
        height: 20px;
        width: 30px;
        background: #0babd9;
        margin-right: 10px;
    }

    .sex-test-table-cur-boy {
        border: 3px solid #000;
    }

    .sex-test-table-girl div {
        height: 20px;
        width: 30px;
        margin-right: 10px;
        background: #d921cc;
    }

    .sex-test-table-cur-girl {
        border: 3px solid #000;
    }

    #china-calendar-result {
        margin: 30px 0;
    }

    #china-calendar-result .boy {
        width: 30px;
        height: 30px;
        float: left;
        background: #0babd9;
        margin: 5px;
    }

    #china-calendar-result .girl {
        width: 30px;
        height: 30px;
        float: left;
        margin: 5px;
        background: #d921cc;
    }

    #japan-result table td {
        width: 30px;
        height: 30px;
    }
</style>
<script type="text/javascript">
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

        $('#china-submit').click(function () {
            var d = new Date();
            var baby_m = d.getMonth() + 1;
            var baby_y = $('#china-conception-y').val();
            var mother_m = parseInt($('#china-mother-m').val());
            var baby_m = $('#china-conception-m').val();
            var mother_y = $('#china-mother-y').val();
            year = baby_y;

            var age = baby_y - mother_y;
            if (baby_m <= mother_m)
                var age = baby_y - mother_y - 1;

            ShowCalendar();
            return false;
        });

        $('body').delegate('#prev', 'click', function () {
            var mother_y = $('#china-mother-y').val();
            var age = year - mother_y - 1;
            if (age < 18)
                return false;

            year--;
            ShowCalendar();
            return false;
        });

        $('body').delegate('#next', 'click', function () {
            var mother_y = $('#china-mother-y').val();
            var age = year - mother_y;
            if (age > 45)
                return false;
            year++;
            ShowCalendar();
            return false;
        });
    });

    function ShowCalendar() {
        var calendar2_html = '<div class="years">';
        calendar2_html += '<a id="prev" href="#">prev</a><br>';

        //calc mother age
        var mother_m = parseInt($('#china-mother-m').val());
        var mother_y = parseInt($('#china-mother-y').val());

        for (var i = 1; i <= 12; i++) {
            var age = year - mother_y;
            if (i <= mother_m)
                var age = year - mother_y - 1;

            var gender = GetGenderFromAge(age, i);
            if (gender == 1)
                calendar2_html += "<div class='boy'></div>";
            if (gender == 2)
                calendar2_html += "<div class='girl'></div>";
            if (gender == 0)
                calendar2_html += "<div></div>";
        }
        calendar2_html += '</div>';
        calendar2_html += '<br><a id="next" href="#">next</a>';
        $('#china-calendar-result').html(year + '<br>' + calendar2_html);
    }

    function GetGenderFromAge(age, month) {
        if (age - 18 < 0)
            return 0;
        if (age - 45 > 0)
            return 0;
        var result = arr[age - 18][month - 1];
//        console.log(result);
        return result;
    }
</script>
<div id="china-calendar">
    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'china-calendar-form',
    'enableAjaxValidation' => false,
));?>

    <big>Год и месяц рождения матери:</big>
    <?php echo $form->dropDownList($model, 'mother_m', HDate::ruMonths(), array('id' => 'china-mother-m', 'class' => 'wid100')); ?>
    <?php echo $form->dropDownList($model, 'mother_y', HDate::Range($year - 18, $year - 46), array('id' => 'china-mother-y', 'class' => 'wid100')); ?>
    <br>
    <big>Месяц зачатия</big>
    <?php echo $form->dropDownList($model, 'baby_m', HDate::ruMonths(), array('id' => 'china-conception-m', 'class' => 'wid100')); ?>
    <?php echo $form->dropDownList($model, 'baby_y', HDate::Range($year + 2, 2000), array('id' => 'china-conception-y', 'class' => 'wid100')); ?>
    <br>
    <?php echo $form->hiddenField($model, 'review_year', array('id' => 'china_review_year')) ?>

    <?php echo CHtml::link('<span><span>Рассчитать</span></span>', '', array(
    'class' => 'btn btn-yellow-medium',
    'id' => 'china-submit'
)); ?>

    <?php $this->endWidget(); ?>
</div>
<div id="china-calendar-result">

</div>
<div class="clear"></div>
