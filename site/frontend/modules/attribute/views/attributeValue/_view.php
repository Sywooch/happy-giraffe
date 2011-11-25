<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('value_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->value_id), array('view', 'id'=>$data->value_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('value_value')); ?>:</b>
	<?php echo CHtml::encode($data->value_value); ?>
	<br />


</div>