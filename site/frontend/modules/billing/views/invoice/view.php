<?php
$this->breadcrumbs=array(
	'Billing Invoices'=>array('index'),
	$model->invoice_id,
);

$this->menu=array(
	array('label'=>'List BillingInvoice', 'url'=>array('index')),
	array('label'=>'Create BillingInvoice', 'url'=>array('create')),
	array('label'=>'Update BillingInvoice', 'url'=>array('update', 'id'=>$model->invoice_id)),
	array('label'=>'Delete BillingInvoice', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->invoice_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BillingInvoice', 'url'=>array('admin')),
);
?>

<h1>View BillingInvoice #<?php echo $model->invoice_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'invoice_id',
		'invoice_order_id',
		'invoice_time',
		'invoice_amount',
		'invoice_currency',
		'invoice_description',
		'invoice_payer_id',
		'invoice_payer_name',
		'invoice_payer_email',
		'invoice_payer_gsm',
		'invoice_status',
		'invoice_status_time',
		'invoice_paid_amount',
		'invoice_paid_time',
	),
)); ?>
