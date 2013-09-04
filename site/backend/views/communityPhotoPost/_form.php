 <?php echo CHtml::link('К таблице', array('CommunityMorningPost/admin')) ?><div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'community-photo-post-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'location'); ?>
		<?php echo $form->textField($model,'location',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'location'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'location_image'); ?>
		<?php echo $form->textField($model,'location_image',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'location_image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'content_id'); ?>
		<?php echo $form->textField($model,'content_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'content_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_published'); ?>
		<?php echo $form->textField($model,'is_published'); ?>
		<?php echo $form->error($model,'is_published'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lat'); ?>
		<?php echo $form->textField($model,'lat',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'lat'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'long'); ?>
		<?php echo $form->textField($model,'long',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'long'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'zoom'); ?>
		<?php echo $form->textField($model,'zoom',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'zoom'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->