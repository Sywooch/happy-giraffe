<?php
$this->breadcrumbs=array(
	'Contest Winners'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ContestWinner', 'url'=>array('index')),
	array('label'=>'Manage ContestWinner', 'url'=>array('admin')),
);
?>

<h1>Create ContestWinner</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>