<?php
$this->breadcrumbs=array(
	'Test Results'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TestResult', 'url'=>array('index')),
	array('label'=>'Create TestResult', 'url'=>array('create')),
	array('label'=>'View TestResult', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TestResult', 'url'=>array('admin')),
);
?>

<h1>Update TestResult <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>