<?php
$this->breadcrumbs=array(
	'Contest Work Comments',
);

$this->menu=array(
	array('label'=>'Create ContestWorkComment', 'url'=>array('create')),
	array('label'=>'Manage ContestWorkComment', 'url'=>array('admin')),
);
?>

<h1>Contest Work Comments</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
