<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('map_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->map_id), array('view', 'id'=>$data->map_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('map_contest_id')); ?>:</b>
	<?php echo CHtml::encode($data->map_contest_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('map_object')); ?>:</b>
	<?php echo CHtml::encode($data->map_object); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('map_object_id')); ?>:</b>
	<?php echo CHtml::encode($data->map_object_id); ?>
	<br />


</div>