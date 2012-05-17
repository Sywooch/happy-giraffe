 <?php echo CHtml::link('К таблице', array('User/admin')) ?><div class="form">

<?php
     $roles = array_shift(Yii::app()->authManager->getAuthItems(2, Yii::app()->user->id));
     if (!empty($roles))
        $model->role = $roles->name;

    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'owner_id'); ?>
		<?php echo $form->dropDownList($model,'owner_id', CHtml::listData(User::model()->findAll('owner_id IS NULL'), 'id', 'name')); ?>
		<?php echo $form->error($model,'owner_id'); ?>
	</div>

     <div class="row">
         <?php echo $form->labelEx($model,'role'); ?>
         <?php echo $form->dropDownList($model,'role', CHtml::listData(Yii::app()->authManager->getRoles(), 'name', 'name')); ?>
         <?php echo $form->error($model,'role'); ?>
     </div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->