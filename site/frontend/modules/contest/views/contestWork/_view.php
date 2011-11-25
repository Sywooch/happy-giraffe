<div class="view">

	<h3><?php echo CHtml::link($data->work_title,$data->url); ?></h3>

	<?php echo CHtml::image($data->getImageUrl('middle'), $data->work_title); ?>

	<?php echo $data->work_text; ?>

	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('work_time')); ?>:</b>
	<?php echo date('d.m.Y H:i', $data->work_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('work_rate')); ?>:</b>
	<?php echo CHtml::encode($data->work_rate); ?>
	<br />

</div>