<?php
echo $formDelivery;
/*
$form=$this->beginWidget('CActiveForm',	
	array(
	'id' => 'show-results-delivery-form',
	    'action'=>array('/delivery/default/showResults'),
)); ?>
<?php echo $form->errorSummary(array($modelDelivery, $model));?>
<?php echo $form->hiddenField($model, 'order_id');?>
<?php echo $form->hiddenField($model, 'delivery_name');?>
<?php echo $form->labelEx($model,'delivery_cost');?>
<?php echo $form->textField($model,'delivery_cost');?>
<?php echo $modelDelivery->getHiddenForm();?>
<?php echo CHtml::submitButton('Accept');?>	
<?php  $this->endWidget(); /**/?>


