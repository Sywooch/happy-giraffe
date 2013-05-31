<?php
$this->breadcrumbs=array(
	'Product Attribute Set Maps',
);

$this->menu=array(
	array('label'=>'Create ProductAttributeSetMap', 'url'=>array('create')),
	array('label'=>'Manage ProductAttributeSetMap', 'url'=>array('admin')),
);
?>

<h1>Product Attribute Set Maps</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
