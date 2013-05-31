<?php
$this->breadcrumbs=array(
	'Банковские счета'=>array('index'),
	$model->requisite_id,
);

$this->menu=array(
	array('label'=>'Банковские счета', 'url'=>array('index')),
	array('label'=>'Добавить', 'url'=>array('create')),
	array('label'=>'Bpvtybnm', 'url'=>array('update', 'id'=>$model->requisite_id)),
//	array('label'=>'Delete BillingSystemBANKRequisite', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->requisite_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Управление счетами', 'url'=>array('admin')),
);
?>

<h1>Просмотр счёта #<?php echo $model->requisite_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'requisite_id',
		'requisite_name',
		'requisite_account',
		'requisite_bank',
		'requisite_bank_address',
		'requisite_bik',
		'requisite_cor_account',
		'requisite_inn',
		'requisite_kpp',
	),
)); ?>
