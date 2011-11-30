<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'bag-item-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->hiddenField($model, 'approved', array('value' => '1')); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'for'); ?>
		<?php echo $form->dropDownList($model,'for', array('0' => 'Для мамы', '1' => 'Для ребёнка')); ?>
		<?php echo $form->error($model,'for'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'category_id'); ?>
		<?php 
			$this->widget('application.components.Relation', array(
					'model' => $model,
					'relation' => 'category',
					'fields' => 'name',
					'allowEmpty' => false,
					'style' => 'dropdownlist',
				)
			); 
		?>
		<?php echo $form->error($model,'category_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->