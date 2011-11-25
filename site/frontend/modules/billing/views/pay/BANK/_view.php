<div class="view">
	<div style="float: right">
	<?=CHtml::beginForm();?>
	<?=CHtml::hiddenField('requisite_id', $data->requisite_id);?>
	<?=CHtml::submitButton(' выбрать ')?>
	<?=CHtml::endForm();?>
	</div>

	<b><?php echo CHtml::encode($data->getAttributeLabel('requisite_name')); ?>:</b>
	<?php echo CHtml::encode($data->requisite_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requisite_bank')); ?>:</b>
	<?php echo CHtml::encode($data->requisite_bank); ?>
	<br />

	<?php if($data->requisite_bank_address): ?>
	<b><?php echo CHtml::encode($data->getAttributeLabel('requisite_bank_address')); ?>:</b>
	<?php echo CHtml::encode($data->requisite_bank_address); ?>
	<br />
	<?php endif; ?>

	<b><?php echo CHtml::encode($data->getAttributeLabel('requisite_account')); ?>:</b>
	<?php echo CHtml::encode($data->requisite_account); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requisite_bik')); ?>:</b>
	<?php echo CHtml::encode($data->requisite_bik); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requisite_inn')); ?>:</b>
	<?php echo CHtml::encode($data->requisite_inn); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requisite_kpp')); ?>:</b>
	<?php echo CHtml::encode($data->requisite_kpp); ?>
	<br />
</div>