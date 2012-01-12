<?php
$this->breadcrumbs=array(
	'Names',
);

$this->menu=array(
	array('label'=>'Create Name', 'url'=>array('create')),
	array('label'=>'Manage Name', 'url'=>array('admin')),
);
?>

<h1>Names</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
