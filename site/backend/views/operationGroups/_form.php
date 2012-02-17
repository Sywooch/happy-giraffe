<?php
/* @var $this BController
 * @var $form CActiveForm
 */
?>
<?php echo CHtml::link('Администрирование групп действий', array('operationGroups/admin')) ?><br><br>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'auth-item-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>
    <?php $am = Yii::app()->authManager;  ?>
    <?php $items = $am->getOperations(); ?>
    <?php foreach ($items as $item): ?>
        <?php echo CHtml::checkBox('Operation['.$item->name.']', $am->hasItemChild($model->name, $item->name)) ?>
        <?php echo CHtml::label($item->description, 'Operation_'.$item->name, array('style'=>'display:inline')) ?><br>
    <?php endforeach; ?>

	<div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->