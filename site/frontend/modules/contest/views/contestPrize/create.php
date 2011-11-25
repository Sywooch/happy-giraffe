<?php
$this->breadcrumbs=array(
	'Contest Prizes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ContestPrize', 'url'=>array('index')),
	array('label'=>'Manage ContestPrize', 'url'=>array('admin')),
);
?>

<h1>Create ContestPrize</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>