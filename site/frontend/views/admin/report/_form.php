<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
<?php echo $form->textField($model,'type',array('size'=>60,'maxlength'=>62)); ?>
<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
<?php echo $form->textArea($model,'text',array('rows'=>6, 'cols'=>50)); ?>
<?php echo $form->error($model,'text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'informer_id'); ?>
<?php echo $form->textField($model,'informer_id',array('size'=>11,'maxlength'=>11)); ?>
<?php echo $form->error($model,'informer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'model'); ?>
<?php echo $form->textField($model,'model',array('size'=>60,'maxlength'=>255)); ?>
<?php echo $form->error($model,'model'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'object_id'); ?>
<?php echo $form->textField($model,'object_id',array('size'=>11,'maxlength'=>11)); ?>
<?php echo $form->error($model,'object_id'); ?>
	</div>


