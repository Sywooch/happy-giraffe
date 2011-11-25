<?php
$this->breadcrumbs=array(
	'Contests'=>array('index'),
	$model->contest_id=>array('view','id'=>$model->contest_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Contest', 'url'=>array('index')),
	array('label'=>'Create Contest', 'url'=>array('create')),
	array('label'=>'View Contest', 'url'=>array('view', 'id'=>$model->contest_id)),
	array('label'=>'Manage Contest', 'url'=>array('admin')),
);
?>

<h1>Update Contest <?php echo $model->contest_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>