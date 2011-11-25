<?php
	$cs = Yii::app()->getClientScript();  
	$cs->registerScript(
		'profiles-general',
		'$("#profile-general-promt").hide();
		$("#change_city").hide();
		$("#change_city_a").click(function() {
			$("#change_city").toggle();
		});',
		CClientScript::POS_END
	);
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id' => 'profile-general',
	'enableAjaxValidation' => FALSE,
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'first_name'); ?>
		<?php echo $form->textField($model,'first_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'first_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'last_name'); ?>
		<?php echo $form->textField($model,'last_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'last_name'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'birthday'); ?>
		<?php
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
		    'name'=>'User[birthday]',
		    'language'=>'ru',
		    'value'=>$model->birthday,
		    'options'=>array(
			'showAnim'=>'fold',
			'dateFormat'=>'yy-mm-dd',
		    ),
		    'htmlOptions'=>array(
			'style'=>'height:20px;'
		    ),
		));
		?>

		<?php echo $form->error($model,'birthday'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'nick'); ?>
		<?php echo $form->textField($model,'nick',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'nick'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'city_id'); ?>
		<p>Текущее местоположение: <?=(is_null($model->settlement_id)) ? 'нет':$model->settlement->name?> <a href="javascript:void(0)" id="change_city_a">Выбрать новое</a></p>
		<div id="change_city">
			<p>Регион: <? echo CHtml::dropDownList('region_id','', $regions,
				array(
					'ajax' => array(
						'type'=>'POST',
						'url'=>CController::createUrl('ajax/settlements'),
						'update'=>'#User_settlement_id',
				))); ?></p>
			<p>Населённый пункт: <? echo CHtml::dropDownList('User[settlement_id]','', array()); ?></p>
		</div>
	</div>

	<div class="row buttons">
		<?php echo CHtml::AjaxSubmitButton('Сохранить', CController::createUrl('ajax/save'),
			array(
				'beforeSend' => 'function() {
					$("#profile-general-button").hide();
					$("#profile-general-promt").text("Пожалуйста, подождите...").show();
				}',
				'success' => 'function() {
					$("#profile-general-button").show();
					$("#profile-general-promt").text("Успешно сохранено").delay(2000).fadeOut("slow");
						
				}'
			),
			array('id' => 'profile-general-button')
		); ?>
	</div>
	
	<p class="note" id="profile-general-promt"></p>

<?php $this->endWidget(); ?>

</div>