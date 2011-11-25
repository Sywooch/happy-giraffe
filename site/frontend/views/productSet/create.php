<?php
$this->breadcrumbs=array(
	'Product Sets'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage ProductSet', 'url'=>array('admin')),
);
?>

<h1>Create ProductSet</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>