<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'community_id'); ?>
<?php echo $form->textField($model,'community_id',array('size'=>11,'maxlength'=>11)); ?>
<?php echo $form->error($model,'community_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type_id'); ?>
<?php echo $form->textField($model,'type_id',array('size'=>11,'maxlength'=>11)); ?>
<?php echo $form->error($model,'type_id'); ?>
	</div>


<label for="Community">Belonging Community</label><?php 
					$this->widget('application.components.Relation', array(
							'model' => $model,
							'relation' => 'community',
							'fields' => 'name',
							'allowEmpty' => false,
							'style' => 'dropdownlist',
							)
						); ?>
			<label for="CommunityContentType">Belonging CommunityContentType</label><?php 
					$this->widget('application.components.Relation', array(
							'model' => $model,
							'relation' => 'type',
							'fields' => 'name',
							'allowEmpty' => false,
							'style' => 'dropdownlist',
							)
						); ?>
			