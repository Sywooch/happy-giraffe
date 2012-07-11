 <?php echo CHtml::link('К таблице', array('/admin/Query/admin')) ?><div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'query-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'keyword_id'); ?>
		<?php echo $form->textField($model,'keyword_id'); ?>
		<?php echo $form->error($model,'keyword_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'visits'); ?>
		<?php echo $form->textField($model,'visits',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'visits'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'page_views'); ?>
		<?php echo $form->textField($model,'page_views',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'page_views'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'denial'); ?>
		<?php echo $form->textField($model,'denial'); ?>
		<?php echo $form->error($model,'denial'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'depth'); ?>
		<?php echo $form->textField($model,'depth'); ?>
		<?php echo $form->error($model,'depth'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'visit_time'); ?>
		<?php echo $form->textField($model,'visit_time'); ?>
		<?php echo $form->error($model,'visit_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'parsing'); ?>
		<?php echo $form->textField($model,'parsing'); ?>
		<?php echo $form->error($model,'parsing'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'yandex_parsed'); ?>
		<?php echo $form->textField($model,'yandex_parsed'); ?>
		<?php echo $form->error($model,'yandex_parsed'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'google_parsed'); ?>
		<?php echo $form->textField($model,'google_parsed'); ?>
		<?php echo $form->error($model,'google_parsed'); ?>
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