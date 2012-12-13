 <?php echo CHtml::link('К таблице', array('CookRecipeTag/admin')) ?><div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cook-recipe-tag-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
        <?php $this->widget('site.frontend.extensions.ckeditor.CKEditorWidget', array('model' => $model, 'attribute' => 'description')); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text_title'); ?>
		<?php echo $form->textField($model,'text_title',array('size'=>80,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'text_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
        <?php $this->widget('site.frontend.extensions.ckeditor.CKEditorWidget', array('model' => $model, 'attribute' => 'text')); ?>
		<?php echo $form->error($model,'text'); ?>
	</div>

	<div class="row buttons">
        <input type="hidden" name="redirect_to" id="redirect_to" value="">
        <?php
        if ($model->isNewRecord) {
            echo CHtml::submitButton('Создать', array('onclick' => 'js:$("#redirect_to").val("refresh");'));
        } else {
            echo CHtml::submitButton('Сохранить');
            echo CHtml::submitButton('Сохранить и продолжить', array('onclick' => 'js:$("#redirect_to").val("refresh");'));
        }
        ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->