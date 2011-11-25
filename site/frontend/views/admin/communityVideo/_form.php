<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'link'); ?>
			<?php
				$model->text = str_replace('<!--more-->', '<hr class="redactor_cut" />', $model->text);
				$this->widget('ext.imperaviRedactor.EImperaviRedactorWidget', array(
					'model' => $model,
					'attribute' => 'text',
					'options' => array(
						'image_upload' => $this->createUrl('ajax/imageUpload'),
						'toolbar' => 'custom',
					),
					'htmlOptions' => array(
						'cols' => 70,
						'rows' => 10,
					),
				));
			?>
<?php echo $form->error($model,'link'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
<?php echo $form->textArea($model,'text',array('rows'=>6, 'cols'=>50)); ?>
<?php echo $form->error($model,'text'); ?>
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
			