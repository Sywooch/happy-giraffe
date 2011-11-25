<?php
$this->breadcrumbs=array(
	'Product Types'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ProductType', 'url'=>array('index')),
	array('label'=>'Create ProductType', 'url'=>array('create')),
);
?>

<h1>Manage Product Types</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-type-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'type_id',
		array(
			'name'=>'type_image',
			'value'=>'$data->type_image->getUrl()',
			'type'=>'image',
			'filter'=>false,
		),
		'type_title',
		'type_text',
		array(
			'name'=>'type_attribute_set_id',
			'value'=>'$data->getSetTitle()',
			'filter'=>$model->getAllSets(),
		),
//		'type_time',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
