<?php
$this->breadcrumbs=array(
	'Product'=>array('/admin/product/view','id'=>$model->image_product_id),
	'Product Images'=>array('admin','id'=>$model->image_product_id),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create ProductImage', 'url'=>array('create','id'=>$model->image_product_id)),
);
?>

<h1>Manage Product Images</h1>

<?php $this->widget('ext.imageGridView.imageGridView', array(
	'id'=>'product-image-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'width'=>70,
	'height'=>100,
	'columns'=>array(
//		'image_id',
//		'image_product_id',
//		'image_file',
		array(
			'name'=>'product_image',
			'value'=>'$data->image_file->getUrl("product_thumb")',
			'type'=>'image',
			'filter'=>false,
		),
//		'image_text',
//		'image_time',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
