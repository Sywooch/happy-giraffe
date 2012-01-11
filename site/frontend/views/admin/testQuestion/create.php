<?php
$this->breadcrumbs=array(
	'Test Questions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TestQuestion', 'url'=>array('index')),
	array('label'=>'Manage TestQuestion', 'url'=>array('admin')),
);
?>

<h1>Create TestQuestion</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>