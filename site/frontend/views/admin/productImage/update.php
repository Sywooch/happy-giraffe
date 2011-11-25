<?php
$this->breadcrumbs=array(
	'Product'=>array('/product/view','id'=>$model->image_product_id),
	'Product Images'=>array('admin','id'=>$model->image_product_id),
	$model->image_id=>array('view','id'=>$model->image_id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create ProductImage', 'url'=>array('create','id'=>$model->image_product_id)),
	array('label'=>'View ProductImage', 'url'=>array('view', 'id'=>$model->image_id)),
	array('label'=>'Manage ProductImage', 'url'=>array('admin','id'=>$model->image_product_id)),
);
?>

<h1>Update ProductImage <?php echo $model->image_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>