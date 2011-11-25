<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment_user_id')); ?>:</b>
	<?php echo $data->user->first_name . ' ' . $data->user->last_name; ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment_text')); ?>:</b>
	<?php echo CHtml::encode($data->comment_text); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment_time')); ?>:</b>
	<?php echo date('d.m.Y H:i',$data->comment_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment_answer')); ?>:</b>
	<?php echo CHtml::encode($data->comment_answer); ?>
	<br />


</div>