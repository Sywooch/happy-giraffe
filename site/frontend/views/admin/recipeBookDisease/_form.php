<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
			</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
<?php
	$this->widget('ext.ckeditor.CKEditorWidget', array(
		'model' => $model,
		'attribute' => 'text',
	));
?>
<?php echo $form->error($model,'text'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'with_recipies'); ?>
<?php echo $form->checkBox($model,'with_recipies'); ?>
<?php echo $form->error($model,'with_recipies'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reasons_name'); ?>
<?php echo $form->textField($model,'reasons_name',array('size'=>60,'maxlength'=>255)); ?>
<?php echo $form->error($model,'reasons_name'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'reasons_text'); ?>
<?php
	$this->widget('ext.ckeditor.CKEditorWidget', array(
		'model' => $model,
		'attribute' => 'reasons_text',
	));
?>
<?php echo $form->error($model,'reasons_text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'symptoms_name'); ?>
<?php echo $form->textField($model,'symptoms_name',array('size'=>60,'maxlength'=>255)); ?>
<?php echo $form->error($model,'symptoms_name'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'symptoms_text'); ?>
<?php
	$this->widget('ext.ckeditor.CKEditorWidget', array(
		'model' => $model,
		'attribute' => 'symptoms_text',
	));
?>
<?php echo $form->error($model,'symptoms_text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'treatment_name'); ?>
<?php echo $form->textField($model,'treatment_name',array('size'=>60,'maxlength'=>255)); ?>
<?php echo $form->error($model,'treatment_name'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'treatment_text'); ?>
<?php
	$this->widget('ext.ckeditor.CKEditorWidget', array(
		'model' => $model,
		'attribute' => 'treatment_text',
	));
?>
<?php echo $form->error($model,'treatment_text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'prophylaxis_name'); ?>
<?php echo $form->textField($model,'prophylaxis_name',array('size'=>60,'maxlength'=>255)); ?>
<?php echo $form->error($model,'prophylaxis_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'prophylaxis_text'); ?>
<?php
	$this->widget('ext.ckeditor.CKEditorWidget', array(
		'model' => $model,
		'attribute' => 'prophylaxis_text',
	));
?>
<?php echo $form->error($model,'prophylaxis_text'); ?>
	</div>


<label for="RecipeBookDiseaseCategory">Belonging RecipeBookDiseaseCategory</label><?php 
					$this->widget('application.components.Relation', array(
							'model' => $model,
							'relation' => 'category',
							'fields' => 'name',
							'allowEmpty' => false,
							'style' => 'dropdownlist',
							)
						); ?>
			