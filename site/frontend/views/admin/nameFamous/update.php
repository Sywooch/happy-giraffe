<?php
$this->breadcrumbs=array(
	'Name Famouses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List NameFamous', 'url'=>array('index')),
	array('label'=>'Create NameFamous', 'url'=>array('create')),
	array('label'=>'View NameFamous', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage NameFamous', 'url'=>array('admin')),
);
?>

<h1>Update NameFamous <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>