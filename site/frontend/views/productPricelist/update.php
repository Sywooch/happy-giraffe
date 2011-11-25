<?php
$this->breadcrumbs=array(
	'Product Pricelists'=>array('admin'),
	$model->pricelist_title,
	'Update',
);

$this->menu=array(
	array('label'=>'Create ProductPricelist', 'url'=>array('create')),
	array('label'=>'Manage ProductPricelist', 'url'=>array('admin')),
);
?>

<h1>Update Product Pricelist <?php echo $model->pricelist_title; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>