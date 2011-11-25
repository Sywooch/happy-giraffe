<?php
$this->breadcrumbs=array(
	'Contest Maps',
);

$this->menu=array(
	array('label'=>'Create ContestMap', 'url'=>array('create')),
	array('label'=>'Manage ContestMap', 'url'=>array('admin')),
);
?>

<h1>Contest Maps</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
