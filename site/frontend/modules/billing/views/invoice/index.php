<?php
$this->breadcrumbs=array(
	'Billing Invoices',
);

$this->menu=array(
	array('label'=>'Create BillingInvoice', 'url'=>array('create')),
	array('label'=>'Manage BillingInvoice', 'url'=>array('admin')),
);
?>

<h1>Billing Invoices</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
