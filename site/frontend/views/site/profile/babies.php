<?
	$cs = Yii::app()->getClientScript();  
	$cs->registerScript(
		'babies',
		'$("div.baby div.form").hide();
		$("div.baby a.show").click(function() {
			$(this).parents("div.baby").children("div.form").toggle();
		});',
		CClientScript::POS_END
	);
?>
<? foreach ($babies as $group): ?>
	<? if ( ! empty($group['content'])): ?>
		<h3><?=$group['label']?></h3>
		<? foreach ($group['content'] as $b): ?>
			<div class="baby" id="baby-<?php echo $b->id; ?>">
			
				<p><a href="#" class="show"><?php echo empty($b->name) ? 'Ребенок без имени' : $b->name ?></a></p>
			
				<div class="form">
			
				<?php $form=$this->beginWidget('CActiveForm', array(
					'enableAjaxValidation' => FALSE,
					'htmlOptions' => array(
						'enctype' => 'multipart/form-data',
					),
				)); ?>
			
				<?php echo $form->errorSummary($b); ?>

				<?php echo $form->hiddenField($b,'id'); ?>

				<div class="row">
					<?php echo $form->labelEx($b,'name'); ?>
					<?php echo $form->textField($b,'name',array('size'=>60,'maxlength'=>255)); ?>
					<?php echo $form->error($b,'name'); ?>
				</div>
			
				<div class="row">
					<?php echo $form->labelEx($b,'birthday'); ?>
					<?php
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
					    'name'=>'Baby[birthday]',
					    'language'=>'ru',
					    'value'=>$b->birthday,
					    'options'=>array(
						'showAnim'=>'fold',
						'dateFormat'=>'yy-mm-dd',
					    ),
					    'htmlOptions'=>array(
						'id' => 'baby-birthday-' . $b->id,
						'style'=>'height:20px;'
					    ),
					));
					?>
					
					<?php echo $form->error($b,'birthday'); ?>
				</div>
				
				<div class="row buttons">
					<?php echo CHtml::AjaxSubmitButton('Сохранить', CController::createUrl('ajax/savechild'),
						array(
							'dataType' => 'json',
							'beforeSend' => 'function() {
								$("#baby-' . $b->id . ' .profile-babies-button").hide();
								$("#baby-' . $b->id . ' .profile-babies-promt").text("Пожалуйста, подождите...").show();
							}',
							'success' => 'function(data) {
								$("#baby-' . $b->id . ' .profile-babies-button").show();
								$("#baby-' . $b->id . ' .show").text(data.name);
								$("#baby-' . $b->id . ' .profile-babies-promt").text("Успешно сохранено").delay(2000).fadeOut("slow");
						
							}'
						),
						array('class' => 'profile-babies-button')
					); ?>
				</div>
				
				<p class="note profile-babies-promt"></p>
			
				<?php $this->endWidget(); ?>
			
				</div>
			
			</div>
		<? endforeach; ?>
	<? endif; ?>
<? endforeach; ?>