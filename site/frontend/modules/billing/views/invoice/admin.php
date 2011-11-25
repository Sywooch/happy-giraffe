<?php
$this->breadcrumbs=array(
	'Billing Invoices'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List BillingInvoice', 'url'=>array('index')),
	array('label'=>'Create BillingInvoice', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('billing-invoice-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Billing Invoices</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'billing-invoice-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'invoice_id',
		'invoice_order_id',
		'invoice_time',
		'invoice_amount',
		'invoice_currency',
		'invoice_description',
		/*
		'invoice_payer_id',
		'invoice_payer_name',
		'invoice_payer_email',
		'invoice_payer_gsm',
		'invoice_status',
		'invoice_status_time',
		'invoice_paid_amount',
		'invoice_paid_time',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
