<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
			<?php
				$this->widget('ext.imperaviRedactor.EImperaviRedactorWidget', array(
					'model' => $model,
					'attribute' => 'text',
					'options' => array(
						'image_upload' => $this->createUrl('ajax/imageUpload'),
					),
					'htmlOptions' => array(
						'cols' => 70,
						'rows' => 10,
					),
				));
			?>
<?php echo $form->error($model,'text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created'); ?>
<?php echo $form->textField($model,'created'); ?>
<?php echo $form->error($model,'created'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'author_id'); ?>
<?php echo $form->textField($model,'author_id',array('size'=>11,'maxlength'=>11)); ?>
<?php echo $form->error($model,'author_id'); ?>
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


<label for="User">Belonging User</label><?php 
					$this->widget('application.components.Relation', array(
							'model' => $model,
							'relation' => 'author',
							'fields' => 'external_id',
							'allowEmpty' => false,
							'style' => 'dropdownlist',
							)
						); ?>
			