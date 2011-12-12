<?php
/* @var $this Controller
 * @var $form CActiveForm
 */
?>
<div id="blood-group">
    <?php echo CHtml::beginForm() ?>

    <big>Группа крови матери:</big>
    <?php echo CHtml::dropDownList('mother_blood_group', 1, array(1=>1, 2=>2, 3=>3, 4=>4), array('empty' => ' ', 'id' => 'mother_blood_group')) ?>
    <br>
    <big>Группа крови отца:</big>
    <?php echo CHtml::dropDownList('father_blood_group', 1, array(1=>1, 2=>2, 3=>3, 4=>4), array('empty' => ' ', 'id' => 'father_blood_group')) ?>
    <br>

    <?php echo CHtml::link('<span><span>Рассчитать</span></span>', '#',
    array(
        'class' => 'btn btn-yellow-medium',
        'id' => 'blood-group-link'
    )); ?>
    <?php echo CHtml::endForm(); ?>
</div>
<div id="blood-group-result">

</div>