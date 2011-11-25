<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('map_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->map_id), array('view', 'id'=>$data->map_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('map_attribute_id')); ?>:</b>
	<?php echo CHtml::encode($data->map_attribute_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('map_value_id')); ?>:</b>
	<?php echo CHtml::encode($data->map_value_id); ?>
	<br />


</div>