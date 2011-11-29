<?php
$this->breadcrumbs=array(
	'Bag Items'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BagItem', 'url'=>array('index')),
	array('label'=>'Manage BagItem', 'url'=>array('admin')),
);
?>

<h1>Create BagItem</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>