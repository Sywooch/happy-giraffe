 <?php echo CHtml::link('К таблице', array('/admin/PagesSearchPhrase/admin')) ?><div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pages-search-phrase-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'page_id'); ?>
		<?php echo $form->textField($model,'page_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'page_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'keyword_id'); ?>
		<?php echo $form->textField($model,'keyword_id'); ?>
		<?php echo $form->error($model,'keyword_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->