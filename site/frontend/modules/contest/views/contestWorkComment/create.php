<?php
$this->breadcrumbs=array(
	'Contest Work Comments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ContestWorkComment', 'url'=>array('index')),
	array('label'=>'Manage ContestWorkComment', 'url'=>array('admin')),
);
?>

<h1>Create ContestWorkComment</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>