<?php
$this->breadcrumbs=array(
	'Contest Work Comments'=>array('index'),
	$model->comment_id=>array('view','id'=>$model->comment_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ContestWorkComment', 'url'=>array('index')),
	array('label'=>'Create ContestWorkComment', 'url'=>array('create')),
	array('label'=>'View ContestWorkComment', 'url'=>array('view', 'id'=>$model->comment_id)),
	array('label'=>'Manage ContestWorkComment', 'url'=>array('admin')),
);
?>

<h1>Update ContestWorkComment <?php echo $model->comment_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>