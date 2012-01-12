<?php
$this->breadcrumbs=array(
	'Name Famouses',
);

$this->menu=array(
	array('label'=>'Create NameFamous', 'url'=>array('create')),
	array('label'=>'Manage NameFamous', 'url'=>array('admin')),
);
?>

<h1>Name Famouses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
