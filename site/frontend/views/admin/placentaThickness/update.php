<?php
$this->breadcrumbs=array(
	'Placenta Thicknesses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PlacentaThickness', 'url'=>array('index')),
	array('label'=>'Create PlacentaThickness', 'url'=>array('create')),
	array('label'=>'View PlacentaThickness', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PlacentaThickness', 'url'=>array('admin')),
);
?>

<h1>Update PlacentaThickness <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>