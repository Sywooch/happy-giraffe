<?php
/* @var $baby Baby
 */
if ($baby === null){
    $baby_id = '';
    $day = date('j');
    $month = date('m');
    $year = date('Y');
}
else{
    $baby_id = $baby->id;
    $baby = Baby::model()->findByPk($baby_id);
    $day = date('j',strtotime($baby->birthday));
    $month = date('m',strtotime($baby->birthday));
    $year = date('Y',strtotime($baby->birthday));
}
?>
<div class="form">

    <?php echo CHtml::beginForm() ?>

    <?php echo CHtml::dropDownList('day', $day, HDate::Days(),array('id'=>'day-'.$baby_id,'class'=>'wid100')); ?>
    <?php echo CHtml::dropDownList('month', $month, HDate::ruMonths(),array('id'=>'month-'.$baby_id,'class'=>'wid100')); ?>
    <?php echo CHtml::dropDownList('year', $year, HDate::Range(1990, 2020),array('id'=>'year-'.$baby_id,'class'=>'wid100')); ?>
    <?php echo CHtml::hiddenField('baby_id', $baby_id) ?>

    <?php echo CHtml::ajaxSubmitButton('Submit',$this->createUrl('/vaccineCalendar/default/VaccineTable'),array(
        'type'=>'POST',
        'success'=>'function(data){$("#vaccine-result'.$baby_id.'").html(data);}'
    )); ?>

    <?php echo CHtml::endForm() ?>

</div>
<div id="vaccine-result<?php echo $baby_id ?>">

</div>

<p>TEXT</p>