<?php
$this->breadcrumbs=array(
	'Contest Winners',
);

$this->menu=array(
	array('label'=>'Create ContestWinner', 'url'=>array('create')),
	array('label'=>'Manage ContestWinner', 'url'=>array('admin')),
);
?>

<h1>Contest Winners</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
