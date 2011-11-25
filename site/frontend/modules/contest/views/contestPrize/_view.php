<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('prize_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->prize_id), array('view', 'id'=>$data->prize_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('prize_contest_id')); ?>:</b>
	<?php echo CHtml::encode($data->prize_contest_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('prize_place')); ?>:</b>
	<?php echo CHtml::encode($data->prize_place); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('prize_item_id')); ?>:</b>
	<?php echo CHtml::encode($data->prize_item_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('prize_text')); ?>:</b>
	<?php echo CHtml::encode($data->prize_text); ?>
	<br />


</div>