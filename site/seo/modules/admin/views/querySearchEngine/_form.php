 <?php echo CHtml::link('К таблице', array('/admin/QuerySearchEngine/admin')) ?><div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'query-search-engine-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'query_id'); ?>
		<?php echo $form->textField($model,'query_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'query_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'se_id'); ?>
		<?php echo $form->textField($model,'se_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'se_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'se_page'); ?>
		<?php echo $form->textField($model,'se_page',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'se_page'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'se_url'); ?>
		<?php echo $form->textField($model,'se_url',array('size'=>60,'maxlength'=>1024)); ?>
		<?php echo $form->error($model,'se_url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'visits'); ?>
		<?php echo $form->textField($model,'visits'); ?>
		<?php echo $form->error($model,'visits'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->