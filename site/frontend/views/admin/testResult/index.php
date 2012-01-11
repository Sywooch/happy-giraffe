<?php
$this->breadcrumbs=array(
	'Test Results',
);

$this->menu=array(
	array('label'=>'Create TestResult', 'url'=>array('create')),
	array('label'=>'Manage TestResult', 'url'=>array('admin')),
);
?>

<h1>Test Results</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
