 <?php echo CHtml::link('К таблице', array('/admin/SearchPhraseVisit/admin')) ?><div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'search-phrase-visit-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'search_phrase_id'); ?>
		<?php echo $form->textField($model,'search_phrase_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'search_phrase_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'se_id'); ?>
		<?php echo $form->textField($model,'se_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'se_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'visits'); ?>
		<?php echo $form->textField($model,'visits'); ?>
		<?php echo $form->error($model,'visits'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'week'); ?>
		<?php echo $form->textField($model,'week'); ?>
		<?php echo $form->error($model,'week'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'year'); ?>
		<?php echo $form->textField($model,'year'); ?>
		<?php echo $form->error($model,'year'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->