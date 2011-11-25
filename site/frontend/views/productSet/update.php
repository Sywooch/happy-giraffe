<?php
$this->breadcrumbs=array(
	'Product Sets'=>array('admin'),
	$model->set_title,
	'Update',
);

$this->menu=array(
	array('label'=>'Create ProductSet', 'url'=>array('create')),
	array('label'=>'Manage ProductSet', 'url'=>array('admin')),
);
?>

<h1>Update Product Set <?php echo $model->set_title; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<?php echo $this->renderPartial('fancybox', array('model'=>$model)); ?>