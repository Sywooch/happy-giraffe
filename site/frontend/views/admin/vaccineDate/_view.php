<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vaccine_id')); ?>:</b>
	<?php echo CHtml::encode($data->vaccine_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time_from')); ?>:</b>
	<?php echo CHtml::encode($data->time_from); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time_to')); ?>:</b>
	<?php echo CHtml::encode($data->time_to); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('adult')); ?>:</b>
	<?php echo CHtml::encode($data->adult); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('interval')); ?>:</b>
	<?php echo CHtml::encode($data->interval); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('every_period')); ?>:</b>
	<?php echo CHtml::encode($data->every_period); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('age_text')); ?>:</b>
	<?php echo CHtml::encode($data->age_text); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('text')); ?>:</b>
	<?php echo CHtml::encode($data->text); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vaccination_type')); ?>:</b>
	<?php echo CHtml::encode($data->vaccination_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vote_decline')); ?>:</b>
	<?php echo CHtml::encode($data->vote_decline); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vote_agree')); ?>:</b>
	<?php echo CHtml::encode($data->vote_agree); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vote_did')); ?>:</b>
	<?php echo CHtml::encode($data->vote_did); ?>
	<br />

	*/ ?>

</div>
