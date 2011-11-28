<?php
$this->breadcrumbs=array(
	'Bag Categories',
);

$this->menu=array(
	array('label'=>'Create BagCategory', 'url'=>array('create')),
	array('label'=>'Manage BagCategory', 'url'=>array('admin')),
);
?>

<h1>Bag Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
