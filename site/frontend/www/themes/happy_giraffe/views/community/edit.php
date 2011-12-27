<div class="inner">
	<?php $form = $this->beginWidget('CActiveForm', array(
		'htmlOptions' => array(
			'enctype' => 'multipart/form-data',
		),
	)); ?>
	<?php echo CHtml::errorSummary(array($content_model, $slave_model)); ?>
	<?php echo $form->hiddenField($content_model, 'type_id', array('value' => $content_type->id)); ?>
	<div class="content-title">Редактировать:</div>
	
	<div class="new">
		<?php $this->renderPartial('add/_form_' . $content_type->slug, array(
			'communities' => $communities,
			'form' => $form,
			'content_model' => $content_model,
			'slave_model' => $slave_model,
			'community' => $community,
		)); ?>
		
		<div class="button_panel">
			<button class="btn btn-gray-medium"><span><span>Отменить</span></span></button>
			<!--<button class="btn btn-yellow-medium"><span><span>Предпросмотр</span></span></button>-->
			<button class="btn btn-green-medium"><span><span>Сохранить</span></span></button>
		</div>
	</div>
	<?php $this->endWidget(); ?>
</div>