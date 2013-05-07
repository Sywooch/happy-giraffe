<?php echo CHtml::link('К таблице', array('GeoCity/admin')) ?><div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'geo-city-form',
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
		<?php echo $form->labelEx($model,'name_from'); ?>
		<?php echo $form->textField($model,'name_from',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name_from'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name_between'); ?>
		<?php echo $form->textField($model,'name_between',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name_between'); ?>
	</div>

	<div class="row buttons">
        <input type="hidden" name="redirect_to" id="redirect_to" value="">
        <?php
        if ($model->isNewRecord) {
            echo CHtml::submitButton('Создать', array('onclick' => 'js:$("#redirect_to").val("refresh");'));
        } else {
            echo CHtml::submitButton('Сохранить');
        }
        ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->