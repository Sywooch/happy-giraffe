<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('number')); ?>:</b>
	<?php echo CHtml::encode($data->number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('item_total')); ?>:</b>
	<?php echo CHtml::encode($data->item_total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total')); ?>:</b>
	<?php echo CHtml::encode($data->total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('state')); ?>:</b>
	<?php echo CHtml::encode($data->state); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('adjustment_total')); ?>:</b>
	<?php echo CHtml::encode($data->adjustment_total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('credit_total')); ?>:</b>
	<?php echo CHtml::encode($data->credit_total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('completed_at')); ?>:</b>
	<?php echo CHtml::encode($data->completed_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bill_address_id')); ?>:</b>
	<?php echo CHtml::encode($data->bill_address_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ship_address_id')); ?>:</b>
	<?php echo CHtml::encode($data->ship_address_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_total')); ?>:</b>
	<?php echo CHtml::encode($data->payment_total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shipping_method_id')); ?>:</b>
	<?php echo CHtml::encode($data->shipping_method_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shipment_state')); ?>:</b>
	<?php echo CHtml::encode($data->shipment_state); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_state')); ?>:</b>
	<?php echo CHtml::encode($data->payment_state); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('special_instructions')); ?>:</b>
	<?php echo CHtml::encode($data->special_instructions); ?>
	<br />

	*/ ?>

</div>