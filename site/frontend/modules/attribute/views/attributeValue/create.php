<?php
$this->breadcrumbs=array(
	'Product Attribute Values'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProductAttributeValue', 'url'=>array('index')),
	array('label'=>'Manage ProductAttributeValue', 'url'=>array('admin')),
);
?>

<h1>Create ProductAttributeValue</h1>

<?php echo $this->renderPartial('/attributeValue/_form', array('model'=>$model)); ?>