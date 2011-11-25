<?php
$this->breadcrumbs=array(
	'Products'=>array('admin'),
	$model->product_title=>array('view','id'=>$model->product_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Product', 'url'=>array('index')),
	array('label'=>'Create Product', 'url'=>array('create')),
	array('label'=>'View Product', 'url'=>$model->getUrl()),
	array('label'=>'Manage Product', 'url'=>array('admin')),
);
?>

<h1>Update Product <?php echo $model->product_title; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>