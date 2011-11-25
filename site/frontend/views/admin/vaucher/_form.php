<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vaucher-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'vaucher_code'); ?>
		<?php echo $form->textField($model,'vaucher_code',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'vaucher_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vaucher_discount'); ?>
		<?php echo $form->textField($model,'vaucher_discount',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'vaucher_discount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vaucher_from_time'); ?>
		<?php
//		echo $form->textField($model,'vaucher_from_time',array('size'=>10,'maxlength'=>10));
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute' => 'vaucher_from_time',
			// additional javascript options for the date picker plugin
			'options' => array(
				'showAnim' => 'fold',
				'dateFormat' => 'dd.mm.yy',
			),
		));
		?>
		<?php echo $form->error($model,'vaucher_from_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vaucher_till_time'); ?>
		<?php
//		echo $form->textField($model,'vaucher_till_time',array('size'=>10,'maxlength'=>10));
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute' => 'vaucher_till_time',
			// additional javascript options for the date picker plugin
			'options' => array(
				'showAnim' => 'fold',
				'dateFormat' => 'dd.mm.yy',
			),
		));
		?>
		<?php echo $form->error($model,'vaucher_till_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vaucher_text'); ?>
		<?php echo $form->textArea($model,'vaucher_text',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'vaucher_text'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->