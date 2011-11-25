<?php
$this->breadcrumbs=array(
	'Contest Maps'=>array('index'),
	$model->map_id=>array('view','id'=>$model->map_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ContestMap', 'url'=>array('index')),
	array('label'=>'Create ContestMap', 'url'=>array('create')),
	array('label'=>'View ContestMap', 'url'=>array('view', 'id'=>$model->map_id)),
	array('label'=>'Manage ContestMap', 'url'=>array('admin')),
);
?>

<h1>Update ContestMap <?php echo $model->map_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>