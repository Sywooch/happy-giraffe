<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('map_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->map_id), array('view', 'id'=>$data->map_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('map_set_id')); ?>:</b>
	<?php echo CHtml::encode($data->map_set_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('map_attribute_id')); ?>:</b>
	<?php echo CHtml::encode($data->map_attribute_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('map_attribute_title')); ?>:</b>
	<?php echo CHtml::encode($data->map_attribute_title); ?>
	<br />


</div>