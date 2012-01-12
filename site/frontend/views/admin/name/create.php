<?php
$this->breadcrumbs=array(
	'Names'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Name', 'url'=>array('index')),
	array('label'=>'Manage Name', 'url'=>array('admin')),
);
?>

<h1>Create Name</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>