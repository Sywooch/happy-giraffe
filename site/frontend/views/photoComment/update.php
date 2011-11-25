<?php
$this->breadcrumbs=array(
	'Photo Comments'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PhotoComment', 'url'=>array('index')),
	array('label'=>'Create PhotoComment', 'url'=>array('create')),
	array('label'=>'View PhotoComment', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PhotoComment', 'url'=>array('admin')),
);
?>

<h1>Update PhotoComment <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>