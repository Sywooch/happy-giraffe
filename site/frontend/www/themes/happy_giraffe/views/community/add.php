<div class="inner">
	<?php $form = $this->beginWidget('CActiveForm'); ?>
	<?php echo CHtml::errorSummary(array($content_model, $slave_model)); ?>
	<?php echo $form->hiddenField($content_model, 'type_id', array('value' => $content_type->id)); ?>
	<div class="content-title">Добавить:</div>
	
	<div class="new">
		<div class="new-header">
			<? foreach ($content_types as $cs): ?>
				<? if ($cs->slug == $content_type->slug): ?>
					<span class="current"><?=$cs->name_accusative?></span>
				<? else: ?>
					<?
						$add_params = array('content_type_slug' => $cs->slug);
						if (!is_null($community_id)) $add_params['community_id'] = $community_id;
						if (!is_null($rubric_id)) $add_params['rubric_id'] = $rubric_id;
						$url = ($cs->slug == 'travel') ? CController::createUrl('community/addTravel') : CController::createUrl('community/add', $add_params);
					?>
					<span><?=CHtml::link($cs->name_accusative, $url)?></span>
				<? endif; ?>
			<? endforeach; ?>
		</div>
		
		<?php $this->renderPartial('add/_form_' . $content_type->slug, array(
			'form' => $form,
			'content_model' => $content_model,
			'slave_model' => $slave_model,
			'community' => $community,
		)); ?>
		
		<div class="button_panel">
			<button class="btn btn-gray-medium"><span><span>Отменить</span></span></button>
			<!--<button class="btn btn-yellow-medium"><span><span>Предпросмотр</span></span></button>-->
			<button class="btn btn-green-medium"><span><span>Добавить</span></span></button>
		</div>
	</div>
	<?php $this->endWidget(); ?>
</div>