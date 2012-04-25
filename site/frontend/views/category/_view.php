<div class="view">

	<h3><?php echo CHtml::link($data->category_name, array(
		'view',
		'id'=>$data->category_id,
	)); ?></h3>

	<?php echo $data->category_text; ?>

</div>