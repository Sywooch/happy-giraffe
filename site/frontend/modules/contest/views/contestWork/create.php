<?php
$this->breadcrumbs=array(
	'Contest Works'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ContestWork', 'url'=>array('index')),
	array('label'=>'Manage ContestWork', 'url'=>array('admin')),
);
?>

<h1>Create ContestWork</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>