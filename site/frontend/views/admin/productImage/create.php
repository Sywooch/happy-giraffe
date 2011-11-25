<?php
$this->breadcrumbs=array(
	'Product'=>array('/product/view','id'=>$model->image_product_id),
	'Product Images'=>array('admin','id'=>$model->image_product_id),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage ProductImage', 'url'=>array('admin','id'=>$model->image_product_id)),
);
?>

<h1>Create ProductImage</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>