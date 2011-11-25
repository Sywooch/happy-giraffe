<?php
$this->breadcrumbs=array(
	'Billing Systems'=>array('index'),
	$model->system_id,
);

$this->menu=array(
	array('label'=>'List BillingSystem', 'url'=>array('index')),
	array('label'=>'Create BillingSystem', 'url'=>array('create')),
	array('label'=>'Update BillingSystem', 'url'=>array('update', 'id'=>$model->system_id)),
	array('label'=>'Delete BillingSystem', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->system_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BillingSystem', 'url'=>array('admin')),
);
?>

<h1>View BillingSystem #<?php echo $model->system_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'system_id',
		'system_code',
		'system_title',
		'system_icon_file',
		'system_params',
		'system_status',
	),
)); ?>
