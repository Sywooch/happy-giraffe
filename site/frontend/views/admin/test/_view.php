<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_image')); ?>:</b>
	<?php echo CHtml::encode($data->start_image); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('css_class')); ?>:</b>
	<?php echo CHtml::encode($data->css_class); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('text')); ?>:</b>
	<?php echo CHtml::encode($data->text); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('slug')); ?>:</b>
	<?php echo CHtml::encode($data->slug); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('result_image')); ?>:</b>
	<?php echo CHtml::encode($data->result_image); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('result_title')); ?>:</b>
	<?php echo CHtml::encode($data->result_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unknown_result_image')); ?>:</b>
	<?php echo CHtml::encode($data->unknown_result_image); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unknown_result_text')); ?>:</b>
	<?php echo CHtml::encode($data->unknown_result_text); ?>
	<br />

	*/ ?>

</div>