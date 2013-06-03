<?php
$this->breadcrumbs=array(
	'Product Attribute Set Maps'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage ProductAttributeSetMap', 'url'=>array('admin')),
);
?>

<h1>Create ProductAttributeSetMap</h1>

<?php
echo $this->renderPartial('/attributeSetMap/_form', array(
	'model'=>$model,
	'attributes'=>$attributes,
));
?>