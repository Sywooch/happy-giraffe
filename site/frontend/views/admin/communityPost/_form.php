<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
<?php echo $form->textArea($model,'text',array('rows'=>6, 'cols'=>50)); ?>
<?php echo $form->error($model,'text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'source_type'); ?>
<?php echo $form->textField($model,'source_type',array('size'=>8,'maxlength'=>8)); ?>
<?php echo $form->error($model,'source_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'internet_link'); ?>
<?php echo $form->textField($model,'internet_link',array('size'=>60,'maxlength'=>255)); ?>
<?php echo $form->error($model,'internet_link'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'internet_favicon'); ?>
<?php echo $form->textField($model,'internet_favicon',array('size'=>60,'maxlength'=>255)); ?>
<?php echo $form->error($model,'internet_favicon'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'internet_title'); ?>
<?php echo $form->textField($model,'internet_title',array('size'=>60,'maxlength'=>255)); ?>
<?php echo $form->error($model,'internet_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'book_author'); ?>
<?php echo $form->textField($model,'book_author',array('size'=>60,'maxlength'=>255)); ?>
<?php echo $form->error($model,'book_author'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'book_name'); ?>
<?php echo $form->textField($model,'book_name',array('size'=>60,'maxlength'=>255)); ?>
<?php echo $form->error($model,'book_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'content_id'); ?>
<?php echo $form->textField($model,'content_id',array('size'=>11,'maxlength'=>11)); ?>
<?php echo $form->error($model,'content_id'); ?>
	</div>


<label for="CommunityContent">Belonging CommunityContent</label><?php 
					$this->widget('application.components.Relation', array(
							'model' => $model,
							'relation' => 'content',
							'fields' => 'name',
							'allowEmpty' => false,
							'style' => 'dropdownlist',
							)
						); ?>
			