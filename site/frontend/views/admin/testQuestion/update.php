<?php
$this->breadcrumbs=array(
	'Test Questions'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TestQuestion', 'url'=>array('index')),
	array('label'=>'Create TestQuestion', 'url'=>array('create')),
	array('label'=>'View TestQuestion', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TestQuestion', 'url'=>array('admin')),
);
?>

<h1>Update TestQuestion <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>