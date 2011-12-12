<?php
/* @var $this Controller
 * @var $form CActiveForm
 */
$model = new JapanCalendarForm;
?>
<div id="japan">
    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'japan-form',
    'enableAjaxValidation' => false,
));?>
    <big>День рождения отца:</big>
    <?php echo $form->dropDownList($model, 'father_m', HDate::ruMonths(), array('id' => 'japan-father-m', 'class' => 'wid100')); ?>
    <br>
    <big>День рождения матери:</big>
    <?php echo $form->dropDownList($model, 'mother_m', HDate::ruMonths(), array('id' => 'japan-mother-m', 'class' => 'wid100')); ?>
    <br>
    <big>Дата зачатия</big>
    <?php echo $form->dropDownList($model, 'baby_d', HDate::Days(), array('id' => 'japan-conception-d', 'class' => 'wid100')); ?>
    <?php echo $form->dropDownList($model, 'baby_m', HDate::ruMonths(), array('id' => 'japan-conception-m', 'class' => 'wid100')); ?>
    <br>
    <?php echo $form->hiddenField($model,'review_month', array('id' => 'japan_review_month')) ?>

    <?php echo CHtml::link('<span><span>Рассчитать</span></span>','#',
    array(
        'class' => 'btn btn-yellow-medium',
        'id'=>'japan-submit'
    )); ?>

    <?php $this->endWidget(); ?>
</div>
<div id="japan-result">

</div>