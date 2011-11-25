<?php
$this->breadcrumbs=array(
	'Contest Maps'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ContestMap', 'url'=>array('index')),
	array('label'=>'Manage ContestMap', 'url'=>array('admin')),
);
?>

<h1>Create ContestMap</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>