<?php
$this->breadcrumbs=array(
	'Products'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Product', 'url'=>array('index')),
	array('label'=>'Create Product', 'url'=>array('create')),
);
?>

<h1>Manage Products</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
//		'product_id',
//		'product_image',
		'product_articul',
		array(
			'name'=>'product_image',
			'value'=>'$data->product_image->getUrl("product_thumb")',
			'type'=>'image',
			'filter'=>false,
		),
//		array(
//			'name'=>'product_type',
//			'filter'=>ProductType::model()->listAll(),
//		),
		'product_title',
		'product_text',
		'product_price',
		array(
			'name'=>'product_status',
			'value'=>'$data->statusText',
			'filter'=>$model->statuses->statuses,
		),
		/*
		'product_keywords',
		'product_description',
		'product_time',
		'product_rate',
		'product_attribute_set_id',
		*/
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view} {imageadd} {subproduct} {attributes} {update} {delete}',
			'buttons'=>array(
				'imageadd'=>array(
					'label'=>'Add image',
					'imageUrl'=>'/shop/images/image_add.png',
					'url'=>'array("/productImage/admin","id"=>$data->product_id)',
				),
				'attributes'=>array(
					'label'=>'Edit attributes',
					'imageUrl'=>'/shop/images/addsearch.png',
					'url'=>'array("attributes","id"=>$data->product_id)',
				),
				'subproduct'=>array(
					'label'=>'Add subproduct',
					'imageUrl'=>'/shop/images/subproduct.png',
					'url'=>'array("addSubProduct","id"=>$data->product_id)',
					'options'=>array(
						'class'=>'subProduct',
					),
				),
			),
		),
	),
)); ?>

<?php
$this->widget('ext.fancybox.EFancyBox',array(
	'target'=>'.subProduct',
));
?>