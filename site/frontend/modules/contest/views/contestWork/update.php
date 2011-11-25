<?php
$this->breadcrumbs=array(
	'Contest Works'=>array('index'),
	$model->work_id=>array('view','id'=>$model->work_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ContestWork', 'url'=>array('index')),
	array('label'=>'Create ContestWork', 'url'=>array('create')),
	array('label'=>'View ContestWork', 'url'=>array('view', 'id'=>$model->work_id)),
	array('label'=>'Manage ContestWork', 'url'=>array('admin')),
);
?>

<h1>Update ContestWork <?php echo $model->work_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>