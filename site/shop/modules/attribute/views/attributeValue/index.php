<?php
$this->breadcrumbs=array(
	'Product Attribute Values',
);

$this->menu=array(
	array('label'=>'Create ProductAttributeValue', 'url'=>array('create')),
	array('label'=>'Manage ProductAttributeValue', 'url'=>array('admin')),
);
?>

<h1>Product Attribute Values</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
