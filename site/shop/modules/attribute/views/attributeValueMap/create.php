<?php
$this->breadcrumbs=array(
	'Product Attribute Value Maps'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProductAttributeValueMap', 'url'=>array('index')),
	array('label'=>'Manage ProductAttributeValueMap', 'url'=>array('admin')),
);
?>

<h1>Create ProductAttributeValueMap</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>