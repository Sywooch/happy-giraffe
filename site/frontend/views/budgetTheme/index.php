<?php
$this->breadcrumbs=array(
	'Budget Themes',
);

$this->menu=array(
	array('label'=>'Create BudgetTheme', 'url'=>array('create')),
	array('label'=>'Manage BudgetTheme', 'url'=>array('admin')),
);
?>

<h1>Budget Themes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
