<?php
/**
 * @var $form CActiveForm
 */

echo CHtml::link('К таблице', array('/admin/site/admin')) ?><div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'site-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'url'); ?>
		<?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'url'); ?>
	</div>

     <div class="row">
         <?php echo $form->labelEx($model,'password'); ?>
         <?php echo $form->textField($model,'password',array('size'=>60,'maxlength'=>255)); ?>
         <?php echo $form->error($model,'password'); ?>
     </div>

     <div class="row">
         <?php echo $form->labelEx($model,'type'); ?>
         <?php echo $form->dropDownList($model,'type', $model->types); ?>
         <?php echo $form->error($model,'type'); ?>
     </div>

     <div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->