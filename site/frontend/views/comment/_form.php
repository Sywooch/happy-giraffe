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
