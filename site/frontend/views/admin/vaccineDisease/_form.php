<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>256)); ?>
<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name_genitive'); ?>
<?php echo $form->textField($model,'name_genitive',array('size'=>60,'maxlength'=>255)); ?>
<?php echo $form->error($model,'name_genitive'); ?>
	</div>


