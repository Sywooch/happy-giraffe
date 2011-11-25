<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('attribute_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->attribute_id), array('view', 'id'=>$data->attribute_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('attribute_title')); ?>:</b>
	<?php echo CHtml::encode($data->attribute_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('attribute_text')); ?>:</b>
	<?php echo CHtml::encode($data->attribute_text); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('attribute_type')); ?>:</b>
	<?php echo CHtml::encode($data->attribute_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('attribute_required')); ?>:</b>
	<?php echo CHtml::encode($data->attribute_required); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('attribute_is_insearch')); ?>:</b>
	<?php echo CHtml::encode($data->attribute_is_insearch); ?>
	<br />


</div>