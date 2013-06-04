<div class="form wide">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-attribute-set-map-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
    'focus'=>array($model,'map_attribute_title'),
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'map_attribute_title'); ?>
		<?php echo $form->textField($model,'map_attribute_title',array('size'=>2,'maxlength'=>2)); ?>
		<?php echo $form->error($model,'map_attribute_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'map_attribute_id'); ?>
		<?php echo $form->dropDownList($model,'map_attribute_id',$attributes,array(
			'empty'=>'Select attribute'
		)); ?>
		<?php echo $form->error($model,'map_attribute_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->