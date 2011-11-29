<?php
$this->breadcrumbs=array(
	'Bag Items',
);

$this->menu=array(
	array('label'=>'Create BagItem', 'url'=>array('create')),
	array('label'=>'Manage BagItem', 'url'=>array('admin')),
);
?>

<h1>Bag Items</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
