<?php
$this->breadcrumbs=array(
	'Contest Users'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ContestUser', 'url'=>array('index')),
	array('label'=>'Manage ContestUser', 'url'=>array('admin')),
);
?>

<h1>Create ContestUser</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>