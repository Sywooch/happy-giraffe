<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->invoice_id), array('view', 'id'=>$data->invoice_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_order_id')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_order_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_time')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_amount')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_currency')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_currency); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_description')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_payer_id')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_payer_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_payer_name')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_payer_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_payer_email')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_payer_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_payer_gsm')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_payer_gsm); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_status')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_status_time')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_status_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_paid_amount')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_paid_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_paid_time')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_paid_time); ?>
	<br />

	*/ ?>

</div>