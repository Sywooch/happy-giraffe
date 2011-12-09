<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created'); ?>
<?php echo $form->textField($model,'created'); ?>
<?php echo $form->error($model,'created'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'views'); ?>
<?php echo $form->textField($model,'views',array('size'=>11,'maxlength'=>11)); ?>
<?php echo $form->error($model,'views'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rating'); ?>
<?php echo $form->textField($model,'rating',array('size'=>11,'maxlength'=>11)); ?>
<?php echo $form->error($model,'rating'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'author_id'); ?>
<?php echo $form->textField($model,'author_id',array('size'=>11,'maxlength'=>11)); ?>
<?php echo $form->error($model,'author_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rubric_id'); ?>
<?php echo $form->textField($model,'rubric_id',array('size'=>11,'maxlength'=>11)); ?>
<?php echo $form->error($model,'rubric_id'); ?>
	</div>


<label for="CommunityRubric">Belonging CommunityRubric</label><?php 
					$this->widget('application.components.Relation', array(
							'model' => $model,
							'relation' => 'rubric',
							'fields' => 'name',
							'allowEmpty' => false,
							'style' => 'dropdownlist',
							)
						); ?>
			<label for="CommunityVideo">Belonging CommunityVideo</label><?php 
					$this->widget('application.components.Relation', array(
							'model' => $model,
							'relation' => 'video',
							'fields' => 'link',
							'allowEmpty' => false,
							'style' => 'dropdownlist',
							)
						); ?>
			<label for="CommunityArticle">Belonging CommunityPost</label><?php 
					$this->widget('application.components.Relation', array(
							'model' => $model,
							'relation' => 'post',
							'fields' => 'text',
							'allowEmpty' => false,
							'style' => 'dropdownlist',
							)
						); ?>
			