<?php
$day = date('j');
$month = date('m');
$year = date('Y');
?>
<div class="vaccination-birthday">
    <?php echo CHtml::beginForm() ?>

    <big>День рождения:</big>
    <?php echo CHtml::dropDownList('day', $day, HDate::Days(),array('id'=>'day-','class'=>'wid100')); ?>
    <?php echo CHtml::dropDownList('month', $month, HDate::ruMonths(),array('id'=>'month-','class'=>'wid100')); ?>
    <?php echo CHtml::dropDownList('year', $year, HDate::Range(1990, 2020),array('id'=>'year-','class'=>'wid100')); ?>
    <?php echo CHtml::hiddenField('baby_id', '') ?>

    <?php echo CHtml::ajaxLink('<span><span>Рассчитать</span></span>',$this->createUrl('/vaccineCalendar/default/VaccineTable'),array(
            'type'=>'POST',
            'data' => 'js:jQuery(this).parents("form").serialize()',
            'success'=>'function(data){$("#vaccine-result").html(data);}'
        ),
        array(
            'class'=>'btn btn-yellow-medium'
        )); ?>

    <?php echo CHtml::endForm() ?>
</div>
<div id="vaccine-result">

</div>