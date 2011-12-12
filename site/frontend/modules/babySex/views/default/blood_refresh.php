<?php
/* @var $this Controller
 * @var $form CActiveForm
 */
$year = date('Y');
$model = new BloodRefreshForm();
?>
<div id="blood-update">
    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'blood-refresh-form',
    'enableAjaxValidation' => false,
));?>

    <big>День рождения отца:</big>
    <?php echo $form->dropDownList($model, 'father_d', HDate::Days(), array('id' => 'father-d', 'class' => 'wid100')); ?>
    <?php echo $form->dropDownList($model, 'father_m', HDate::ruMonths(), array('id' => 'father-m', 'class' => 'wid100')); ?>
    <?php echo $form->dropDownList($model, 'father_y', HDate::Range($year - 15, 1950), array('id' => 'father-y', 'class' => 'wid100')); ?>
    <br>
    <big>День рождения матери:</big>
    <?php echo $form->dropDownList($model, 'mother_d', HDate::Days(), array('id' => 'mother-d', 'class' => 'wid100')); ?>
    <?php echo $form->dropDownList($model, 'mother_m', HDate::ruMonths(), array('id' => 'mother-m', 'class' => 'wid100')); ?>
    <?php echo $form->dropDownList($model, 'mother_y', HDate::Range($year - 15, 1950), array('id' => 'mother-y', 'class' => 'wid100')); ?>
    <br>
    <big>Дата зачатия</big>
    <?php echo $form->dropDownList($model, 'baby_d', HDate::Days(), array('id' => 'conception-d', 'class' => 'wid100')); ?>
    <?php echo $form->dropDownList($model, 'baby_m', HDate::ruMonths(), array('id' => 'conception-m', 'class' => 'wid100')); ?>
    <?php echo $form->dropDownList($model, 'baby_y', HDate::Range(1950, $year), array('id' => 'conception-y', 'class' => 'wid100')); ?>
    <br>
    <?php echo $form->hiddenField($model, 'review_month', array('id' => 'blood_refr_review_month')) ?>
    <?php echo $form->hiddenField($model, 'review_year', array('id' => 'blood_refr_review_year')) ?>

    <?php echo CHtml::ajaxLink('<span><span>Рассчитать</span></span>', $this->createUrl('/babySex/default/bloodUpdate'), array(
        'type' => 'POST',
        'data' => 'js:jQuery(this).parents("form").serialize()',
        'success' => 'function(data){
            $("#blood-update-result").html(data);
            $("#blood_refr_review_year").val($("#conception-y").val());
            $("#blood_refr_review_month").val($("#conception-m").val());
        }'
    ),
    array(
        'class' => 'btn btn-yellow-medium'
    )); ?>

    <?php $this->endWidget(); ?>
</div>
<div id="blood-update-result">

</div>