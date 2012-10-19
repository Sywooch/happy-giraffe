 <?php echo CHtml::link('К таблице', array('/admin/Page/admin')) ?><div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'page-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'entity'); ?>
		<?php echo $form->textField($model,'entity',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'entity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'entity_id'); ?>
		<?php echo $form->textField($model,'entity_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'entity_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'url'); ?>
		<?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>1024)); ?>
		<?php echo $form->error($model,'url'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->