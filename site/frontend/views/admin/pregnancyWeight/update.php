<?php
$this->breadcrumbs=array(
	'Pregnancy Weights'=>array('index'),
	$model->week=>array('view','id'=>$model->week),
	'Update',
);

$this->menu=array(
	array('label'=>'List PregnancyWeight', 'url'=>array('index')),
	array('label'=>'Create PregnancyWeight', 'url'=>array('create')),
	array('label'=>'View PregnancyWeight', 'url'=>array('view', 'id'=>$model->week)),
	array('label'=>'Manage PregnancyWeight', 'url'=>array('admin')),
);
?>

<h1>Update PregnancyWeight <?php echo $model->week; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>