<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->order_id), array('view', 'id'=>$data->order_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_status')); ?>:</b>
	<?php echo CHtml::encode($data->order_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_time')); ?>:</b>
	<?php echo CHtml::encode($data->order_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->order_user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_item_count')); ?>:</b>
	<?php echo CHtml::encode($data->order_item_count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_price')); ?>:</b>
	<?php echo CHtml::encode($data->order_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_price_total')); ?>:</b>
	<?php echo CHtml::encode($data->order_price_total); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('order_width')); ?>:</b>
	<?php echo CHtml::encode($data->order_width); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_volume')); ?>:</b>
	<?php echo CHtml::encode($data->order_volume); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_description')); ?>:</b>
	<?php echo CHtml::encode($data->order_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_vaucher_id')); ?>:</b>
	<?php echo CHtml::encode($data->order_vaucher_id); ?>
	<br />

	*/ ?>

</div>