<?php
$this->breadcrumbs=array(
	'Vauchers',
);

$this->menu=array(
	array('label'=>'Create Vaucher', 'url'=>array('create')),
	array('label'=>'Manage Vaucher', 'url'=>array('admin')),
);
?>

<h1>Vauchers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
