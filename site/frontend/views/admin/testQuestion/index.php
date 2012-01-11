<?php
$this->breadcrumbs=array(
	'Test Questions',
);

$this->menu=array(
	array('label'=>'Create TestQuestion', 'url'=>array('create')),
	array('label'=>'Manage TestQuestion', 'url'=>array('admin')),
);
?>

<h1>Test Questions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
