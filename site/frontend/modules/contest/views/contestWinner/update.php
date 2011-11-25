<?php
$this->breadcrumbs=array(
	'Contest Winners'=>array('index'),
	$model->winner_id=>array('view','id'=>$model->winner_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ContestWinner', 'url'=>array('index')),
	array('label'=>'Create ContestWinner', 'url'=>array('create')),
	array('label'=>'View ContestWinner', 'url'=>array('view', 'id'=>$model->winner_id)),
	array('label'=>'Manage ContestWinner', 'url'=>array('admin')),
);
?>

<h1>Update ContestWinner <?php echo $model->winner_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>