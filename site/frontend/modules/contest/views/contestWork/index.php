<?php
$this->breadcrumbs=array(
	'Contest Works',
);

$this->menu=array(
	array('label'=>'Create ContestWork', 'url'=>array('create')),
	array('label'=>'Manage ContestWork', 'url'=>array('admin')),
);
?>

<h1>Contest Works</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
