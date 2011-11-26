<?php
$this->breadcrumbs=array(
	'Pregnancy Weights',
);

$this->menu=array(
	array('label'=>'Create PregnancyWeight', 'url'=>array('create')),
	array('label'=>'Manage PregnancyWeight', 'url'=>array('admin')),
);
?>

<h1>Pregnancy Weights</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
