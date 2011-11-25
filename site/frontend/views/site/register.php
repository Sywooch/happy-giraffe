<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>
	
	<? if ($regdata === NULL): ?>
	
	<div class="row">
		<?php Yii::app()->eauth->renderWidget(array('action' => 'site/register')); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'first_name'); ?>
		<?php echo $form->textField($model,'first_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'first_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
	
	<? else: ?>
	
	<div class="row">
		<?php echo CHtml::image($regdata['photo']); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'first_name'); ?>
		<?php echo $form->textField($model,'first_name',array('size'=>60,'maxlength'=>255,'value'=>isset($regdata['first_name'])?$regdata['first_name']:'')); ?>
		<?php echo $form->error($model,'first_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255,'value'=>isset($regdata['email'])?$regdata['email']:'')); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
	
	<? endif; ?>

	<hr />
	
	<div class="row">
		<?php echo $form->labelEx($model,'gender'); ?>
		<?php echo $form->radioButtonList($model,'gender',array(0 => 'женщина', 1 => 'мужчина'),array('separator' => '')); ?>
		<?php echo $form->error($model,'gender'); ?>
	</div>
	
	<hr />
	
	<div class="row">
		<?php echo CHtml::label('Ждем ребенка', 'waiting_for_baby'); ?>
		<?php echo CHtml::checkBox('age_group[0]', TRUE, array('value' => 1, 'uncheckValue' => 0)); ?>
	</div>
	
	<div class="row">
		<?php echo CHtml::label('0-1', 'age_group[]'); ?>
		<?php echo CHtml::textField('age_group[]', '0'); ?>
	</div>
	
	<div class="row">
		<?php echo CHtml::label('1-3', 'age_group_2'); ?>
		<?php echo CHtml::textField('age_group[]', '0'); ?>
	</div>
	
	<div class="row">
		<?php echo CHtml::label('3-7', 'age_group_3'); ?>
		<?php echo CHtml::textField('age_group[]', '0'); ?>
	</div>
	
	<div class="row">
		<?php echo CHtml::label('7-18', 'age_group_4'); ?>
		<?php echo CHtml::textField('age_group[]', '0'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->