<?php
$this->breadcrumbs=array(
	'Orders'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Order', 'url'=>array('index')),
	array('label'=>'Create Order', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('order-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Orders</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'order-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'order_id',
		array(
			'name'=>'order_status',
			'value'=>'$data->getStatusText()',
			'filter'=>$model->statuses->statuses,
		),
		array(
			'name'=>'order_payed',
			'type'=>'boolean',
			'filter'=>array(
				0=>'No',
				1=>'Yes',
			),
		),
//		'order_time',
//		'order_user_id',
		'order_item_count',
		'order_price',
		'order_price_total',
		'order_price_delivery',
		/*
		'order_width',
		'order_volume',
		'order_description',
		'order_vaucher_id',
		*/
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view}',
		),
	),
)); ?>
