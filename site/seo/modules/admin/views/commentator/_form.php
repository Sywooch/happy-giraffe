<?php
/* @var $this SController
 * @var $form CActiveForm
 */
?><?php echo CHtml::link('К таблице', array('Commentator/admin')) ?><div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'commentator-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'manager_id'); ?>
		<?php echo $form->dropDownList($model,'manager_id', CHtml::listData(SeoUser::model()->findAll('owner_id IS NULL'), 'id', 'name'), array('empty'=>' ')); ?>
		<?php echo $form->error($model,'manager_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'commentator_id'); ?>
		<?php echo $form->textField($model,'commentator_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'commentator_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->