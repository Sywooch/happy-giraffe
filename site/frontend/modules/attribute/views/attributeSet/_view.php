<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('set_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->set_id), array('view', 'id'=>$data->set_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('set_title')); ?>:</b>
	<?php echo CHtml::encode($data->set_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('set_text')); ?>:</b>
	<?php echo CHtml::encode($data->set_text); ?>
	<br />


</div>