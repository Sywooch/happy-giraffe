<?php
/* @var $this Controller
 * @var $form CActiveForm
 */
?>

<script>
    $(function () {
        $('#check-all-oper').bind('change', function () {
            if ($(this).is(':checked')) {
                var allCheckboxes = $("#all-rights input:checkbox:enabled");
                var notChecked = allCheckboxes.not(':checked');
                notChecked.attr('checked', 'checked');
            } else {
                var Checked = $("#all-rights input:checkbox:enabled:checked");
                Checked.removeAttr('checked');
            }
        })
    });
</script>
<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-form',
    'enableAjaxValidation' => false,
)); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'role'); ?>
        <?php echo CHtml::dropDownList('User[role]', $model->getRole(), CHtml::listData(Yii::app()->authManager->getRoles(), 'name', 'name'), array('empty' => ' ')); ?>
        <?php echo $form->error($model, 'role'); ?>
    </div>

    <div class="row">
        <label>Сообщество</label>
        <?php echo CHtml::dropDownList('community_id', '', CHtml::listData(Community::model()->findAll(), 'id', 'title'), array('empty' => 'Все')); ?>
    </div>

    <b>Действия</b><br>

    <div id="all-rights">
        <?php echo CHtml::checkBox('check-all-oper', false, array('class' => 'check-all-oper')) ?> отметить все <br><br>
        <?php $am = Yii::app()->authManager;  ?>
        <?php $items = $am->getOperations(); ?>
        <?php foreach ($items as $item): ?>
        <?php echo CHtml::checkBox('Operation[' . $item->name . ']', $am->isAssigned($item->name, $model->id)) ?>
        <?php echo CHtml::label($item->description, 'Operation_' . $item->name, array('style' => 'display:inline')) ?>
        <br>
        <?php endforeach; ?>
    </div>

    <div style="position:absolute;top:400px;right:200px;">
        <a href="javascript:;" onclick="ChangeUserPassword(this, <?=$model->id ?>);">Change password</a>

        <div class="result"></div>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->