<?php
/* @var $this Controller
 * @var $form CActiveForm
 * @var $model NameFamous
 */
?>
<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'name-famous-form',
    'enableAjaxValidation' => true,
    'htmlOptions'=>array(
    		'enctype'=>'multipart/form-data',
    	),
)); ?>
<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>
<?php echo $model->name->name ?>

<div class="row">
    <?php echo $form->labelEx($model, 'middle_name'); ?>
    <?php echo $form->textField($model, 'middle_name', array('size' => 50, 'maxlength' => 50)); ?>
    <?php echo $form->error($model, 'middle_name'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model, 'last_name'); ?>
    <?php echo $form->textField($model, 'last_name', array('size' => 50, 'maxlength' => 50)); ?>
    <?php echo $form->error($model, 'last_name'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model, 'description'); ?>
    <?php echo $form->textField($model, 'description', array('size' => 60, 'maxlength' => 256)); ?>
    <?php echo $form->error($model, 'description'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model, 'image'); ?>
    <?php echo $form->fileField($model, 'image'); ?>
    <?php echo $form->error($model, 'image'); ?>
</div>

<div class="row buttons">
    <?php echo CHtml::submitButton(Yii::t('app', 'Create')); ?>
</div>

<?php $this->endWidget(); ?>
