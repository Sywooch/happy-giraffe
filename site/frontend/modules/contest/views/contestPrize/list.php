<h1>Manage Contest Prizes</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'contest-prize-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
//		'prize_id',
//		'prize_contest_id',
		'prize_place',
		'prize_item_id',
		'prize_text',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update} {delete}',
			'updateButtonUrl'=>'array("/contest/contestPrize/update","id"=>$data->prize_id)',
			'deleteButtonUrl'=>'array("/contest/contestPrize/delete","id"=>$data->prize_id)',
			'visible'=>true,
		),
	),
)); ?>

<?php
/**
 * @todo 'visible'=>true,
 */
?>