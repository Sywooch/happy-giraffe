<?php
/* @var $this SController
 * @var $form CActiveForm
 */
?><?php echo CHtml::link('К таблице', array('siteGroup/admin')) ?><div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'commentator-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'group_id'); ?>
		<?php echo $form->dropDownList($model,'group_id', CHtml::listData(Site::model()->findAll(), 'id', 'name'), array('empty'=>' ')); ?>
		<?php echo $form->error($model,'group_id'); ?>
	</div>

	<div class="row">
        <?php echo $form->labelEx($model,'site_id'); ?>
        <?php echo $form->dropDownList($model,'site_id', CHtml::listData(Site::model()->findAll(), 'id', 'name'), array('empty'=>' ')); ?>
        <?php echo $form->error($model,'site_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->