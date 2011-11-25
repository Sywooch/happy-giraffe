<?php
$this->breadcrumbs=array(
	'Contest Prizes',
);

$this->menu=array(
	array('label'=>'Create ContestPrize', 'url'=>array('create')),
	array('label'=>'Manage ContestPrize', 'url'=>array('admin')),
);
?>

<h1>Contest Prizes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
