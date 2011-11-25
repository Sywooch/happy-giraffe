<?php
$this->breadcrumbs=array(
	'Contest Users'=>array('index'),
	$model->user_id=>array('view','id'=>$model->user_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ContestUser', 'url'=>array('index')),
	array('label'=>'Create ContestUser', 'url'=>array('create')),
	array('label'=>'View ContestUser', 'url'=>array('view', 'id'=>$model->user_id)),
	array('label'=>'Manage ContestUser', 'url'=>array('admin')),
);
?>

<h1>Update ContestUser <?php echo $model->user_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>