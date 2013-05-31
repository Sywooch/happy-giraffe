<?php
$this->breadcrumbs=array(
	'Billing Invoices'=>array('index'),
	$model->invoice_id=>array('view','id'=>$model->invoice_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BillingInvoice', 'url'=>array('index')),
	array('label'=>'Create BillingInvoice', 'url'=>array('create')),
	array('label'=>'View BillingInvoice', 'url'=>array('view', 'id'=>$model->invoice_id)),
	array('label'=>'Manage BillingInvoice', 'url'=>array('admin')),
);
?>

<h1>Update BillingInvoice <?php echo $model->invoice_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>