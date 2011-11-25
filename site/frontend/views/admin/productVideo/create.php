<?php
$this->breadcrumbs=array(
	'Product Videos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProductVideo', 'url'=>array('index')),
	array('label'=>'Manage ProductVideo', 'url'=>array('admin')),
);
?>

<h1>Create ProductVideo</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>