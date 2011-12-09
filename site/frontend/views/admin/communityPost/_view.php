<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('text')); ?>:</b>
	<?php echo CHtml::encode($data->text); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('source_type')); ?>:</b>
	<?php echo CHtml::encode($data->source_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('internet_link')); ?>:</b>
	<?php echo CHtml::encode($data->internet_link); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('internet_favicon')); ?>:</b>
	<?php echo CHtml::encode($data->internet_favicon); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('internet_title')); ?>:</b>
	<?php echo CHtml::encode($data->internet_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('book_author')); ?>:</b>
	<?php echo CHtml::encode($data->book_author); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('book_name')); ?>:</b>
	<?php echo CHtml::encode($data->book_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content_id')); ?>:</b>
	<?php echo CHtml::encode($data->content_id); ?>
	<br />

	*/ ?>

</div>
