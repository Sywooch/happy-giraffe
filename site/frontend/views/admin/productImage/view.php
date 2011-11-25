<?php
$this->breadcrumbs=array(
	'Product'=>array('/admin/product/view','id'=>$model->image_product_id),
	'Product Images'=>array('admin','id'=>$model->image_product_id),
	$model->image_id,
);

$this->menu=array(
	array('label'=>'Create ProductImage', 'url'=>array('create','id'=>$model->image_product_id)),
	array('label'=>'Update ProductImage', 'url'=>array('update', 'id'=>$model->image_id)),
	array('label'=>'Delete ProductImage', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->image_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProductImage', 'url'=>array('admin','id'=>$model->image_product_id)),
);
?>

<h1>View ProductImage #<?php echo $model->image_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'image_id',
//		'image_product_id',
		array(
			'name'=>'product_image',
			'value'=>$model->image_file->getUrl("product"),
			'type'=>'image',
		),
		'image_text',
//		'image_time',
	),
)); ?>
