<?php
$this->breadcrumbs=array(
	'Vauchers'=>array('index'),
	$model->vaucher_id=>array('view','id'=>$model->vaucher_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Vaucher', 'url'=>array('index')),
	array('label'=>'Create Vaucher', 'url'=>array('create')),
	array('label'=>'View Vaucher', 'url'=>array('view', 'id'=>$model->vaucher_id)),
	array('label'=>'Manage Vaucher', 'url'=>array('admin')),
);
?>

<h1>Update Vaucher <?php echo $model->vaucher_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>