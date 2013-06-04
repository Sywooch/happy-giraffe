<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-attribute-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'attribute_title'); ?>
		<?php echo $form->textField($model,'attribute_title',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'attribute_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'attribute_text'); ?>
		<?php echo $form->textArea($model,'attribute_text',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'attribute_text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'attribute_type'); ?>
		<?php echo $form->dropDownList($model,'attribute_type',$model->types->statuses); ?>
		<?php echo $form->error($model,'attribute_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'attribute_required'); ?>
		<?php echo $form->checkBox($model,'attribute_required'); ?>
		<?php echo $form->error($model,'attribute_required'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'attribute_is_insearch'); ?>
        <?php echo $form->checkBox($model,'attribute_is_insearch'); ?>
        <?php echo $form->error($model,'attribute_is_insearch'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'price_influence'); ?>
        <?php echo $form->checkBox($model,'price_influence'); ?>
        <?php echo $form->error($model,'price_influence'); ?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->