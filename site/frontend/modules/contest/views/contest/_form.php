<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contest-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array(
		'enctype'=>'multipart/form-data',
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'contest_title'); ?>
		<?php echo $form->textField($model,'contest_title',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'contest_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contest_text'); ?>
		<?php echo $form->textArea($model,'contest_text',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'contest_text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contest_image'); ?>
		<?php echo $form->fileField($model, 'contest_image'); ?>
		<?php echo $form->error($model,'contest_image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contest_from_time'); ?>
		<?php
//		echo $form->textField($model,'contest_from_time');
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute' => 'contest_from_time',
			// additional javascript options for the date picker plugin
			'options' => array(
				'showAnim' => 'fold',
				'dateFormat' => 'dd.mm.yy',
			),
		));
		?>
		<?php echo $form->error($model,'contest_from_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contest_till_time'); ?>
		<?php
//		echo $form->textField($model,'contest_till_time');
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute' => 'contest_till_time',
			// additional javascript options for the date picker plugin
			'options' => array(
				'showAnim' => 'fold',
				'dateFormat' => 'dd.mm.yy',
			),
		));
		?>
		<?php echo $form->error($model,'contest_till_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contest_status'); ?>
		<?php echo $form->dropDownList($model,'contest_status',$model->statuses->statuses); ?>
		<?php echo $form->error($model,'contest_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contest_stop_reason'); ?>
		<?php echo $form->textArea($model,'contest_stop_reason',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'contest_stop_reason'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->