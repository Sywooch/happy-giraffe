<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->product_id), array('view', 'id'=>$data->product_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_category_id')); ?>:</b>
	<?php echo CHtml::encode($data->product_category_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_title')); ?>:</b>
	<?php echo CHtml::encode($data->product_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_text')); ?>:</b>
	<?php echo CHtml::encode($data->product_text); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_image')); ?>:</b>
	<?php echo CHtml::encode($data->product_image); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_keywords')); ?>:</b>
	<?php echo CHtml::encode($data->product_keywords); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_description')); ?>:</b>
	<?php echo CHtml::encode($data->product_description); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('product_time')); ?>:</b>
	<?php echo CHtml::encode($data->product_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_rate')); ?>:</b>
	<?php echo CHtml::encode($data->product_rate); ?>
	<br />

	*/ ?>

</div>