<?php
/* @var $this Controller
 * @var $form CActiveForm
 */
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'name-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gender'); ?>
		<?php echo $form->dropDownList($model,'gender', array('1'=>'мужское','2'=>'женское')); ?>
		<?php echo $form->error($model,'gender'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'translate'); ?>
		<?php echo $form->textField($model,'translate',array('size'=>60,'maxlength'=>512)); ?>
		<?php echo $form->error($model,'translate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'origin'); ?>
		<?php echo $form->textField($model,'origin',array('size'=>60,'maxlength'=>2048)); ?>
		<?php echo $form->error($model,'origin'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'options'); ?>
		<?php echo $form->textField($model,'options',array('size'=>60,'maxlength'=>512)); ?>
		<?php echo $form->error($model,'options'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sweet'); ?>
		<?php echo $form->textField($model,'sweet',array('size'=>60,'maxlength'=>512)); ?>
		<?php echo $form->error($model,'sweet'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'middle_names'); ?>
		<?php echo $form->textField($model,'middle_names',array('size'=>60,'maxlength'=>1024)); ?>
		<?php echo $form->error($model,'middle_names'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->