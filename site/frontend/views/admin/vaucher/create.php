<?php
$this->breadcrumbs=array(
	'Vauchers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Vaucher', 'url'=>array('index')),
	array('label'=>'Manage Vaucher', 'url'=>array('admin')),
);
?>

<h1>Create Vaucher</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>