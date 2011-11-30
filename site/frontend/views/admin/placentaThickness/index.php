<?php
$this->breadcrumbs=array(
	'Placenta Thicknesses',
);

$this->menu=array(
	array('label'=>'Create PlacentaThickness', 'url'=>array('create')),
	array('label'=>'Manage PlacentaThickness', 'url'=>array('admin')),
);
?>

<h1>Placenta Thicknesses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
