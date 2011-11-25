<?php
$this->breadcrumbs=array(
	'Product Videos',
);

$this->menu=array(
	array('label'=>'Create ProductVideo', 'url'=>array('create')),
	array('label'=>'Manage ProductVideo', 'url'=>array('admin')),
);
?>

<h1>Product Videos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
