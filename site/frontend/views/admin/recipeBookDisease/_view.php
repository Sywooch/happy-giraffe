<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('category_id')); ?>:</b>
	<?php echo CHtml::encode($data->category_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('with_recipies')); ?>:</b>
	<?php echo CHtml::encode($data->with_recipies); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('text')); ?>:</b>
	<?php echo CHtml::encode($data->text); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reasons_name')); ?>:</b>
	<?php echo CHtml::encode($data->reasons_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('symptoms_name')); ?>:</b>
	<?php echo CHtml::encode($data->symptoms_name); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('treatment_name')); ?>:</b>
	<?php echo CHtml::encode($data->treatment_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('prophylaxis_name')); ?>:</b>
	<?php echo CHtml::encode($data->prophylaxis_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reasons_text')); ?>:</b>
	<?php echo CHtml::encode($data->reasons_text); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('symptoms_text')); ?>:</b>
	<?php echo CHtml::encode($data->symptoms_text); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('treatment_text')); ?>:</b>
	<?php echo CHtml::encode($data->treatment_text); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('prophylaxis_text')); ?>:</b>
	<?php echo CHtml::encode($data->prophylaxis_text); ?>
	<br />

	*/ ?>

</div>
