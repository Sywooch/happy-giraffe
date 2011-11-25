<?php
$this->breadcrumbs=array(
	'Банковские счета',
);

$this->menu=array(
	array('label'=>'Добавить', 'url'=>array('create')),
	array('label'=>'Управление счетами', 'url'=>array('admin')),
);
?>

<h1>Банковские счета</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
