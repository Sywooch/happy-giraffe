<?php
$this->breadcrumbs=array(
	'Billing Systems'=>array('index'),
	$model->system_id=>array('view','id'=>$model->system_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BillingSystem', 'url'=>array('index')),
	array('label'=>'Create BillingSystem', 'url'=>array('create')),
	array('label'=>'View BillingSystem', 'url'=>array('view', 'id'=>$model->system_id)),
	array('label'=>'Manage BillingSystem', 'url'=>array('admin')),
);
?>

<h1>Update BillingSystem <?php echo $model->system_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>