<?php
/* @var $model HoroscopeCompatibility
 * @var $form CActiveForm
 */
 echo CHtml::link('К таблице', array('/club/HoroscopeCompatibility/admin')) ?><div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'horoscope-compatibility-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'zodiac1'); ?>
		<?php echo $form->dropDownList($model,'zodiac1', Horoscope::model()->zodiac_list); ?>
		<?php echo $form->error($model,'zodiac1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'zodiac2'); ?>
        <?php echo $form->dropDownList($model,'zodiac2', Horoscope::model()->zodiac_list); ?>
		<?php echo $form->error($model,'zodiac2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
		<?php echo $form->textArea($model,'text',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'text'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->