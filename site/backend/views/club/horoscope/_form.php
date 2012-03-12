<?php
/* @var $this Controller
 * @var $form CActiveForm
 * @var $model Horoscope
 */
?>
<?php echo CHtml::link('К таблице', array('/club/horoscope/admin')) ?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'horoscope-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'zodiac'); ?>
		<?php echo $form->dropDownList($model,'zodiac', $model->zodiac_list); ?>
		<?php echo $form->error($model,'zodiac'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'model'=>$model,
        'attribute'=>'date',
        'language'=>'ru',
        'options'=>array(
            'showAnim'=>'fold',
            'dateFormat'=>'yy-mm-dd',
        ),
        'htmlOptions'=>array(
            'style'=>'height:20px;'
        ),
    )); ?>
		<?php echo $form->error($model,'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
		<?php echo $form->textArea($model,'text',array('rows'=>15, 'cols'=>110)); ?>
		<?php echo $form->error($model,'text'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->