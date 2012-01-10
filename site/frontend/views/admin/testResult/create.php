<?php
$this->breadcrumbs=array(
	'Test Results'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TestResult', 'url'=>array('index')),
	array('label'=>'Manage TestResult', 'url'=>array('admin')),
);
?>

<h1>Create TestResult</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>