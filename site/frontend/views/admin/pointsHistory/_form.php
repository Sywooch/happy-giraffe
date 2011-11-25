<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'note'); ?>
<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50)); ?>
<?php echo $form->error($model,'note'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'amount'); ?>
<?php echo $form->textField($model,'amount',array('size'=>5,'maxlength'=>5)); ?>
<?php echo $form->error($model,'amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
<?php echo $form->textField($model,'user_id',array('size'=>11,'maxlength'=>11)); ?>
<?php echo $form->error($model,'user_id'); ?>
	</div>


