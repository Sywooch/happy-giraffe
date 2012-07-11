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

	<div class="row">
		<?php echo $form->labelEx($model,'keyword_group_id'); ?>
		<?php echo $form->textField($model,'keyword_group_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'keyword_group_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'number'); ?>
		<?php echo $form->textField($model,'number'); ?>
		<?php echo $form->error($model,'number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'yandex_pos'); ?>
		<?php echo $form->textField($model,'yandex_pos'); ?>
		<?php echo $form->error($model,'yandex_pos'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'google_pos'); ?>
		<?php echo $form->textField($model,'google_pos'); ?>
		<?php echo $form->error($model,'google_pos'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'yandex_week_visits'); ?>
		<?php echo $form->textField($model,'yandex_week_visits'); ?>
		<?php echo $form->error($model,'yandex_week_visits'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'yandex_month_visits'); ?>
		<?php echo $form->textField($model,'yandex_month_visits'); ?>
		<?php echo $form->error($model,'yandex_month_visits'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'google_week_visits'); ?>
		<?php echo $form->textField($model,'google_week_visits'); ?>
		<?php echo $form->error($model,'google_week_visits'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'google_month_visits'); ?>
		<?php echo $form->textField($model,'google_month_visits'); ?>
		<?php echo $form->error($model,'google_month_visits'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->