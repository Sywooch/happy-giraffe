<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('system_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->system_id), array('view', 'id'=>$data->system_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('system_code')); ?>:</b>
	<?php echo CHtml::encode($data->system_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('system_title')); ?>:</b>
	<?php echo CHtml::encode($data->system_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('system_icon_file')); ?>:</b>
	<?php echo CHtml::encode($data->system_icon_file); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('system_params')); ?>:</b>
	<?php echo CHtml::encode($data->system_params); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('system_status')); ?>:</b>
	<?php echo CHtml::encode($data->system_status); ?>
	<br />


</div>