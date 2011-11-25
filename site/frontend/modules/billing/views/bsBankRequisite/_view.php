<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('requisite_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->requisite_id), array('view', 'id'=>$data->requisite_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requisite_name')); ?>:</b>
	<?php echo CHtml::encode($data->requisite_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requisite_account')); ?>:</b>
	<?php echo CHtml::encode($data->requisite_account); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requisite_bank')); ?>:</b>
	<?php echo CHtml::encode($data->requisite_bank); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requisite_bank_address')); ?>:</b>
	<?php echo CHtml::encode($data->requisite_bank_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requisite_bik')); ?>:</b>
	<?php echo CHtml::encode($data->requisite_bik); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requisite_cor_account')); ?>:</b>
	<?php echo CHtml::encode($data->requisite_cor_account); ?>
	<br />

	
	<b><?php echo CHtml::encode($data->getAttributeLabel('requisite_inn')); ?>:</b>
	<?php echo CHtml::encode($data->requisite_inn); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requisite_kpp')); ?>:</b>
	<?php echo CHtml::encode($data->requisite_kpp); ?>
	<br />

</div>