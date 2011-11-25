<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('category_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->category_id), array('view', 'id'=>$data->category_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('category_lft')); ?>:</b>
	<?php echo CHtml::encode($data->category_lft); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('category_rgt')); ?>:</b>
	<?php echo CHtml::encode($data->category_rgt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('category_level')); ?>:</b>
	<?php echo CHtml::encode($data->category_level); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('category_name')); ?>:</b>
	<?php echo CHtml::encode($data->category_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('category_title')); ?>:</b>
	<?php echo CHtml::encode($data->category_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('category_text')); ?>:</b>
	<?php echo CHtml::encode($data->category_text); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('category_keywords')); ?>:</b>
	<?php echo CHtml::encode($data->category_keywords); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('category_description')); ?>:</b>
	<?php echo CHtml::encode($data->category_description); ?>
	<br />

	*/ ?>

</div>