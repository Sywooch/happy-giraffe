<?php
$this->breadcrumbs=array(
	'Photo Comments',
);

$this->menu=array(
	array('label'=>'Create PhotoComment', 'url'=>array('create')),
	array('label'=>'Manage PhotoComment', 'url'=>array('admin')),
);
?>

<h1>Photo Comments</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
