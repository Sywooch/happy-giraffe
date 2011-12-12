<?php
/**
 * @var $form CActiveForm
 */

$model = new MenstrualCycleForm();
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
Первый день цикла: <?php echo $form->dropDownList($model, 'day', HDate::Days(), array('id' => 'day', 'class' => 'wid100')); ?>
<?php echo $form->dropDownList($model, 'month', HDate::ruMonths(), array('id' => 'month', 'class' => 'wid100')); ?>
<?php echo $form->dropDownList($model, 'year', HDate::Range(1990, 2020), array('id' => 'year', 'class' => 'wid100')); ?>
<br>
Длительность цикла: <?php echo $form->dropDownList($model, 'cycle', HDate::Range(25, 35), array('id' => 'period', 'class' => 'wid100')); ?> дней
<br>
Длительность менструации: <?php echo $form->dropDownList($model, 'critical_period', HDate::Range(3, 7), array('id' => 'critical-period', 'class' => 'wid100')); ?> дней
<br>

<button>Расчитать</button>
<?php $this->endWidget(); ?><br><br>
<div id="result">

</div>