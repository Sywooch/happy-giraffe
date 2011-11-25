<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pic'); ?>
<?php echo $form->textField($model,'pic',array('size'=>60,'maxlength'=>255)); ?>
<?php echo $form->error($model,'pic'); ?>
	</div>


