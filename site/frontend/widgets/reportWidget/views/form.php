<div class="report-block">
	<?php $form = $this->beginWidget('CActiveForm', array('action' => Yii::app()->createUrl('ajax/acceptreport'),
		'htmlOptions' => array(
			'class'=> 'report-form',
		)
	)); ?>
	<?php foreach($source_data as $k => $v): ?>
		<?php echo $form->hiddenField($report, $k, array('value' => $v)); ?>
	<?php endforeach; ?>
	<div class="left-b">
		<big>Укажите нарушение</big>
		<p>
			<?php echo $form->radioButton($report, 'type', array('class' => 'RadioClass', 'id' => 'value1', 'value' => 'Спам')); ?>
			<label for="value1" class="RadioLabelClass">Спам</label>
		</p>
		<p>
			<?php echo $form->radioButton($report, 'type', array('class' => 'RadioClass', 'id' => 'value2', 'value' => 'Оскорбление пользователей')); ?>
			<label for="value2" class="RadioLabelClass">Оскорбление пользователей</label>
		</p>
		<p>
			<?php echo $form->radioButton($report, 'type', array('class' => 'RadioClass', 'id' => 'value3', 'value' => 'Разжигание межнациональной розни')); ?>
			<label for="value3" class="RadioLabelClass">Разжигание межнациональной розни</label>
		</p>
		<p>
			<?php echo $form->radioButton($report, 'type', array('class' => 'RadioClass', 'id' => 'value4', 'value' => 'Другое')); ?>
			<label for="value4" class="RadioLabelClass">Другое</label>
		</p>
	</div>
	<div class="right-b">
		<big>Опишите нарушение (обязательно)</big>
		<?php echo $form->textArea($report, 'text'); ?>
	</div>
	<div class="clear"></div>
	<div class="button_panel">
		<button class="btn btn-gray-medium cancel"><span><span>Отмена</span></span></button>
		<button class="btn btn-red-medium"><span><span>Сообщить об нарушении</span></span></button>
	</div>
	<?php $this->endWidget(); ?>
</div>