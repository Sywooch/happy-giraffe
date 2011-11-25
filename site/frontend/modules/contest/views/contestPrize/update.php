<?php
$this->breadcrumbs=array(
	'Contest Prizes'=>array('index'),
	$model->prize_id=>array('view','id'=>$model->prize_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ContestPrize', 'url'=>array('index')),
	array('label'=>'Create ContestPrize', 'url'=>array('create')),
	array('label'=>'View ContestPrize', 'url'=>array('view', 'id'=>$model->prize_id)),
	array('label'=>'Manage ContestPrize', 'url'=>array('admin')),
);
?>

<h1>Update ContestPrize <?php echo $model->prize_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>