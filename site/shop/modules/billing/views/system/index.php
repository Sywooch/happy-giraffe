<?php
$this->breadcrumbs=array(
	'Billing Systems',
);

$this->menu=array(
	array('label'=>'Create BillingSystem', 'url'=>array('create')),
	array('label'=>'Manage BillingSystem', 'url'=>array('admin')),
);
?>

<h1>Billing Systems</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
