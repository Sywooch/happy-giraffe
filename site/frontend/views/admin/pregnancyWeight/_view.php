<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('week')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->week), array('view', 'id'=>$data->week)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('w1')); ?>:</b>
	<?php echo CHtml::encode($data->w1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('w2')); ?>:</b>
	<?php echo CHtml::encode($data->w2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('w3')); ?>:</b>
	<?php echo CHtml::encode($data->w3); ?>
	<br />


</div>