<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('vaucher_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->vaucher_id), array('view', 'id'=>$data->vaucher_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vaucher_code')); ?>:</b>
	<?php echo CHtml::encode($data->vaucher_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vaucher_discount')); ?>:</b>
	<?php echo CHtml::encode($data->vaucher_discount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vaucher_time')); ?>:</b>
	<?php echo CHtml::encode($data->vaucher_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vaucher_from_time')); ?>:</b>
	<?php echo CHtml::encode($data->vaucher_from_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vaucher_till_time')); ?>:</b>
	<?php echo CHtml::encode($data->vaucher_till_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vaucher_text')); ?>:</b>
	<?php echo CHtml::encode($data->vaucher_text); ?>
	<br />


</div>