<?php
$this->breadcrumbs=array(
	'Product Attribute Sets',
);

$this->menu=array(
	array('label'=>'Create ProductAttributeSet', 'url'=>array('create')),
	array('label'=>'Manage ProductAttributeSet', 'url'=>array('admin')),
);
?>

<h1>Product Attribute Sets</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
