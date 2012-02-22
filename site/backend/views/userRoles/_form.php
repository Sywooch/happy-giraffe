<?php
/* @var $this Controller
 * @var $form CActiveForm
 */
?>
<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-form',
    'enableAjaxValidation' => false,
)); ?>

    <p class="note">Поля с <span class="required">*</span> обязательны.</p>

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

    <b>Действия</b><br>

    <div>
        <?php echo CHtml::checkBox('check-all-oper') ?> отметить все <br><br>
        <?php $am = Yii::app()->authManager;  ?>
        <?php $items = $am->getOperations(); ?>
        <?php foreach ($items as $item): ?>
        <?php echo CHtml::checkBox('Operation[' . $item->name . ']', $am->isAssigned($item->name, $model->id)) ?>
        <?php echo CHtml::label($item->description, 'Operation_' . $item->name, array('style' => 'display:inline')) ?>
        <br>
        <?php endforeach; ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
    $('#check-all-oper').click(function(){
        if ($(this).is(':checked'))
            $(this).parent().find('input[type=checkbox]').attr('checked', true);
        else
            $(this).parent().find('input[type=checkbox]').attr('checked', false);

        return true;
    });
</script>