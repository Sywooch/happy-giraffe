<div class="report-block">
	<?php $form = $this->beginWidget('CActiveForm', array('action' => Yii::app()->createUrl('ajax/acceptreport'),
		'htmlOptions' => array(
			'onsubmit'=> 'return Report.sendForm(this);',
		)
	)); ?>
	<?php foreach($source_data as $k => $v): ?>
		<?php echo $form->hiddenField($report, $k, array('value' => $v)); ?>
	<?php endforeach; ?>
	<div class="left-b">
		<big>Укажите нарушение</big>
        <?php echo $form->radioButtonList($report, 'type', $report->types); ?>
	</div>
	<div class="right-b">
		<big>Опишите нарушение (обязательно)</big>
		<?php echo $form->textArea($report, 'text'); ?>
	</div>
	<div class="clear"></div>
	<div class="button_panel">
		<button class="btn btn-gray-medium" onclick="Report.closeForm(this);"><span><span>Отмена</span></span></button>
		<button class="btn btn-red-medium"><span><span>Сообщить об нарушении</span></span></button>
	</div>
	<?php $this->endWidget(); ?>
</div>