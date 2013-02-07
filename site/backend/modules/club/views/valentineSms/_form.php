 <?php echo CHtml::link('К таблице', array('ValentineSms/admin')) ?><div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'valentine-sms-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title', array('size'=>100)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
		<?php echo $form->textArea($model,'text', array('rows'=>20, 'cols'=>50)); ?>
		<?php echo $form->error($model,'text'); ?>
	</div>

	<div class="row buttons">
        <input type="hidden" name="redirect_to" id="redirect_to" value="">
        <?= CHtml::submitButton('Сохранить');?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->