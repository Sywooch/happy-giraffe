<?php
$this->breadcrumbs=array(
	'Bag Categories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BagCategory', 'url'=>array('index')),
	array('label'=>'Manage BagCategory', 'url'=>array('admin')),
);
?>

<h1>Create BagCategory</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>