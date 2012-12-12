 <?php echo CHtml::link('К таблице', array('/admin/user/admin')) ?><div class="form">

<?php
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

     <div class="row">
         <?php echo $form->labelEx($model,'id'); ?>
         <?php echo $form->textField($model,'id'); ?>
         <?php echo $form->error($model,'id'); ?>
     </div>

     <div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'owner_id'); ?>
		<?php echo $form->dropDownList($model,'owner_id', CHtml::listData(SeoUser::model()->findAll('owner_id IS NULL'), 'id', 'name'), array('empty'=>' ')); ?>
		<?php echo $form->error($model,'owner_id'); ?>
	</div>

     <div class="row">
         <?php echo $form->labelEx($model,'related_user_id'); ?>
         <?php echo $form->textField($model,'related_user_id'); ?>
         <?php echo $form->error($model,'related_user_id'); ?>
     </div>

     <div class="row">
         <?php echo $form->labelEx($model,'role'); ?>
         <?php echo $form->dropDownList($model,'role', CHtml::listData(Yii::app()->authManager->getRoles(), 'name', 'name'), array('empty'=>' ')); ?>
         <?php echo $form->error($model,'role'); ?>
     </div>

     <div style="position:absolute;top:400px;right:200px;">
         <a href="javascript:;" onclick="ChangeUserPassword(this, <?=$model->id ?>);">Change password</a>

         <div class="result"></div>
     </div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

 <script type="text/javascript">
     function ChangeUserPassword(el, id) {
         $.post('/admin/user/changePassword/', {id:id}, function (response) {
             if (response.status) {
                 $(el).next().html(response.result);
             }
         }, 'json');
     }
 </script>
