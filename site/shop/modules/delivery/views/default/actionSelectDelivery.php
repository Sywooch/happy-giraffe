<?php
$form = $this->beginWidget('CActiveForm',
	array(
		'id' => 'select-delivery-form',
		'action'=>array('/delivery/default/createD'
	),
));
?>
<?php echo $form->hiddenField($model, 'order_id');?>
<?php echo $form->labelEx($model, 'delivery_name');?>
<?php echo $form->dropDownList($model,'delivery_name',$modules); ?>
<?php echo CHtml::submitButton('Select');?>	
<?php $this->endWidget(); ?>


