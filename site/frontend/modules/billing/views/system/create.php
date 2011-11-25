<?php
$this->breadcrumbs=array(
	'Billing Systems'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BillingSystem', 'url'=>array('index')),
	array('label'=>'Manage BillingSystem', 'url'=>array('admin')),
);
?>

<h1>Create BillingSystem</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>