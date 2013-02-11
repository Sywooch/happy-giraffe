<?= CHtml::link('К таблице', array('ValentineSms/admin')) ?><div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'valentine-sms-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?= $form->errorSummary($model); ?>

     <div class="row">
         <?= $form->labelEx($model,'id'); ?>
         <?= $form->textField($model,'id'); ?>
         <?= $form->error($model,'id'); ?>
     </div>

	<div class="row">
		<?= $form->labelEx($model,'title'); ?>
		<?= $form->textField($model,'title', array('size'=>100)); ?>
		<?= $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?= $form->labelEx($model,'text'); ?>
		<?= $form->textArea($model,'text', array('rows'=>20, 'cols'=>50)); ?>
		<?= $form->error($model,'text'); ?>
	</div>

	<div class="row buttons">
        <input type="hidden" name="redirect_to" id="redirect_to" value="">
        <?= CHtml::submitButton('Сохранить');?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->