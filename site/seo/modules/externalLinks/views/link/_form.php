 <?php echo CHtml::link('К таблице', array('admin')) ?><div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ellink-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'site_id'); ?>
		<?php echo $form->textField($model,'site_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'site_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'url'); ?>
		<?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>2048)); ?>
		<?php echo $form->error($model,'url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'our_link'); ?>
		<?php echo $form->textField($model,'our_link',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'our_link'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'author_id'); ?>
		<?php echo $form->textField($model,'author_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'author_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created'); ?>
		<?php echo $form->textField($model,'created'); ?>
		<?php echo $form->error($model,'created'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'check_link_time'); ?>
		<?php echo $form->textField($model,'check_link_time'); ?>
		<?php echo $form->error($model,'check_link_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'link_type'); ?>
		<?php echo $form->textField($model,'link_type'); ?>
		<?php echo $form->error($model,'link_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'link_cost'); ?>
		<?php echo $form->textField($model,'link_cost'); ?>
		<?php echo $form->error($model,'link_cost'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'system_id'); ?>
		<?php echo $form->textField($model,'system_id'); ?>
		<?php echo $form->error($model,'system_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->