<?php
/* @var $model PlacentaThicknessForm
 * @var $form CActiveForm
 */

$day = date('j');
$month = date('m');
$year = date('Y');

?>
<style type="text/css">
    input {
        border: 1px solid #000;
    }

    .calendar-table {
        border: 1px solid #000;
        padding-bottom: 10px;
    }

    .calendar-table td {
        padding: 5px 10px;
    }
    .red{
        background: #bd878c;
    }
</style>
<script type="text/javascript">

    // these are labels for the days of the week
    cal_days_labels = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];

    // these are human-readable month name labels, in order
    cal_months_labels = ['Январь', 'Февраль', 'Март', 'Апрель',
        'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь',
        'Октярь', 'Ноябрь', 'Декабрь'];

    // these are the days of the week for each month, in order
    cal_days_in_month = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

    // this is the current date
    cal_current_date = new Date();
    var number_months = 6;
    var critical_days = new Array();

    function Calendar(month, year) {
        this.month = (isNaN(month) || month == null) ? cal_current_date.getMonth() : month;
        this.year = (isNaN(year) || year == null) ? cal_current_date.getFullYear() : year;
        this.html = '';
    }

    Calendar.prototype.generateHTML = function () {
        // get first day of month
        var firstDay = new Date(this.year, this.month, 1);
        var startingDay = firstDay.getDay();
        startingDay--;
        if (startingDay < 0) startingDay = 6;

        // find number of days in month
        var monthLength = cal_days_in_month[this.month];

        // compensate for leap year
        if (this.month == 1) { // February only!
            if ((this.year % 4 == 0 && this.year % 100 != 0) || this.year % 400 == 0) {
                monthLength = 29;
            }
        }

        // do the header
        var monthName = cal_months_labels[this.month]
        var html = '<table class="calendar-table">';
        html += '<tr><th colspan="7">';
        html += monthName + "&nbsp;" + this.year;
        html += '</th></tr>';
        html += '<tr class="calendar-header">';
        for (var i = 0; i <= 6; i++) {
            html += '<td class="calendar-header-day">';
            html += cal_days_labels[i];
            html += '</td>';
        }
        html += '</tr><tr>';

        // fill in the days
        var day = 1;
        // this loop is for is weeks (rows)
        for (var i = 0; i < 9; i++) {
            // this loop is for weekdays (cells)
            for (var j = 0; j <= 6; j++) {
                if (day <= monthLength && (i > 0 || j >= startingDay) && $.inArray(GetDateHash(day, this.month, this.year), critical_days) != -1)
                    html += '<td class="red">';
                else
                    html += '<td>';
                if (day <= monthLength && (i > 0 || j >= startingDay)) {
                    html += day;
                    day++;
                }
                html += '</td>';
            }
            // stop making rows if we've run out of days
            if (day > monthLength) {
                break;
            } else {
                html += '</tr><tr>';
            }
        }
        html += '</tr></table>';

        this.html = html;
    }

    Calendar.prototype.getHTML = function () {
        return this.html;
    }

    Calendar.prototype.NextMonth = function () {
        this.month++;
        if (this.month == 12) {
            this.month = 0;
            this.year++;
        }
    }

    Calendar.prototype.getSeveralMonthHTML = function () {
        this.generateHTML();
        var html = this.getHTML();

        for (var i = 0; i < number_months; i++) {
            this.NextMonth();
            this.generateHTML();
            html += this.getHTML();
        }

        return html;
    }

    function GetDateHash(day, month, year) {
//        console.log(day, month, year);
        return parseInt(parseInt(year) + parseInt(month) * 10000 + parseInt(day) * 1000000);
    }

    function CalculateCriticalDays() {
        critical_days = new Array();
        var d = new Date($('#year').val(), $('#month').val() - 1, $('#day').val());
        var cycle = parseInt($('#period').val());
        var critical_period = parseInt($('#critical-period').val());
        console.log(cycle, critical_period);
        for (var i = 0; i < number_months + 1; i++) {
            for (var j = 1; j < critical_period + 1; j++) {
                var current_day = new Date();
                var plus = parseInt(cycle * i - j + 1);
                current_day.setDate(d.getDate() + plus);
                critical_days.push(GetDateHash(current_day.getDate(), current_day.getMonth(), current_day.getFullYear()))
//                console.log(GetDateHash(current_day.getDate(), current_day.getMonth(), current_day.getFullYear()));
            }
        }

//        console.log(critical_days);
    }

    $(function () {
        $('#menstrual-cycle-form button').click(function () {
            CalculateCriticalDays();
            var cal = new Calendar($('#month').val() - 1, $('#year').val());
            $('#result').html('');
            $('#result').append(cal.getSeveralMonthHTML());

            return false;
        });
    });
</script>
<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'menstrual-cycle-form',
    'enableAjaxValidation' => false,
));?>
<?php echo CHtml::dropDownList('day', $day, HDate::Days(), array('id' => 'day', 'class' => 'wid100')); ?>
<?php echo CHtml::dropDownList('month', $month, HDate::ruMonths(), array('id' => 'month', 'class' => 'wid100')); ?>
<?php echo CHtml::dropDownList('year', $year, HDate::Range(1990, 2020), array('id' => 'year', 'class' => 'wid100')); ?>
<br>
<?php echo CHtml::dropDownList('cycle', 28, HDate::Range(25, 35), array('id' => 'period', 'class' => 'wid100')); ?> дней
<br>
<?php echo CHtml::dropDownList('critical_period', 5, HDate::Range(1, 10), array('id' => 'critical-period', 'class' => 'wid100')); ?> дней
<br>

<button>Расчитать</button>
<?php $this->endWidget(); ?>
<div id="result">

</div>