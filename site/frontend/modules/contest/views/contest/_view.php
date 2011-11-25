<div class="view">

	<h3><?php echo CHtml::link(CHtml::encode($data->contest_title), array('view', 'id'=>$data->contest_id)); ?></h3>

	<b><?php echo CHtml::encode($data->getAttributeLabel('contest_text')); ?>:</b>
	<?php echo CHtml::encode($data->contest_text); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contest_image')); ?>:</b>
	<?php echo CHtml::image($data->getImageUrl('middle'),$data->contest_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contest_from_time')); ?>:</b>
	<?php echo CHtml::encode($data->contest_from_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contest_till_time')); ?>:</b>
	<?php echo CHtml::encode($data->contest_till_time); ?>
	<br />

</div>