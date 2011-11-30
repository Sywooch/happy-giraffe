<?php
$this->breadcrumbs=array(
	'Placenta Thicknesses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PlacentaThickness', 'url'=>array('index')),
	array('label'=>'Manage PlacentaThickness', 'url'=>array('admin')),
);
?>

<h1>Create PlacentaThickness</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>