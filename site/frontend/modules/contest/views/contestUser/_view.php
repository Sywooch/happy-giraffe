<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->user_id), array('view', 'id'=>$data->user_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_contest_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_contest_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_work_count')); ?>:</b>
	<?php echo CHtml::encode($data->user_work_count); ?>
	<br />


</div>