<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('winner_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->winner_id), array('view', 'id'=>$data->winner_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('winner_contest_id')); ?>:</b>
	<?php echo CHtml::encode($data->winner_contest_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('winner_place')); ?>:</b>
	<?php echo CHtml::encode($data->winner_place); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('winner_prize_id')); ?>:</b>
	<?php echo CHtml::encode($data->winner_prize_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('winner_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->winner_user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('winner_work_id')); ?>:</b>
	<?php echo CHtml::encode($data->winner_work_id); ?>
	<br />


</div>