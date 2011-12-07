<?php
/* @var $model PlacentaThicknessForm
 * @var $form CActiveForm
 */

if (!Yii::app()->user->isGuest) {
    $user_cycle = MenstrualCycle::GetUserCycle(Yii::app()->user->getId());
    $day = date('j', strtotime($user_cycle['date']));
    $month = date('m', strtotime($user_cycle['date']));
    $year = date('Y', strtotime($user_cycle['date']));
    $cycle = $user_cycle['cycle'];
    $critical_period = $user_cycle['menstruation'];
} else {
    $day = date('j');
    $month = date('m');
    $year = date('Y');
    $cycle = 25;
    $critical_period = 5;
}
?>
<style type="text/css">
    input {
        border: 1px solid #000;
    }

    .calendar-table {
        border: 1px solid #000;
        padding-bottom: 10px;
        border-collapse: separate;
        border-spacing: 3px;
        margin-right: 20px;
    }

    .calendar-table td {
        padding: 10px 0;
        width: 30px;
        text-align: center;
    }
    #main-calendar td{
        padding: 30px 20px;
        width: 50px;
        font-size: 20px;
    }

    .first_day {
        background: #ff00ef;
    }
    .menstruation {
        background: #fadcde;
    }

    .safety_sex {
        background: #9bfef9;
    }
    .ovulation_probable {
        background: #0ae71d;
    }

    .ovulation_most_probable {
        background: #fea71c;
    }

    .ovulation_can {
        background: #0ae71d;
    }

    .pms {
        background: #fadcde;
    }
</style>
<script type="text/javascript">

    $(function () {
        $('#menstrual-cycle-form button').click(function () {
            $.ajax({
                url:"<?php echo Yii::app()->createUrl("/menstrualCycle/default/calculate") ?>",
                data:$("#menstrual-cycle-form").serialize(),
                type:"POST",
                success:function (data) {
                    $('#result').html(data);
                }
            });
            return false;
        });
    });
</script>
<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'menstrual-cycle-form',
    'enableAjaxValidation' => false,
));?>
Первый день цикла: <?php echo CHtml::dropDownList('day', $day, HDate::Days(), array('id' => 'day', 'class' => 'wid100')); ?>
<?php echo CHtml::dropDownList('month', $month, HDate::ruMonths(), array('id' => 'month', 'class' => 'wid100')); ?>
<?php echo CHtml::dropDownList('year', $year, HDate::Range(1990, 2020), array('id' => 'year', 'class' => 'wid100')); ?>
<br>
Длительность цикла: <?php echo CHtml::dropDownList('cycle', $cycle, HDate::Range(25, 35), array('id' => 'period', 'class' => 'wid100')); ?> дней
<br>
Длительность менструации: <?php echo CHtml::dropDownList('critical_period', $critical_period, HDate::Range(3, 7), array('id' => 'critical-period', 'class' => 'wid100')); ?> дней
<br>

<button>Расчитать</button>
<?php $this->endWidget(); ?><br><br>
<div id="result">

</div>