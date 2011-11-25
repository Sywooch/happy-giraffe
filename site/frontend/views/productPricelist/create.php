<?php
$this->breadcrumbs=array(
	'Product Pricelists'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage ProductPricelist', 'url'=>array('admin')),
);
?>

<h1>Create ProductPricelist</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>