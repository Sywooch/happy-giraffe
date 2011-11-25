<?php
$this->breadcrumbs=array(
	'Budget Themes'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List BudgetTheme', 'url'=>array('index')),
	array('label'=>'Create BudgetTheme', 'url'=>array('create')),
	array('label'=>'Update BudgetTheme', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete BudgetTheme', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BudgetTheme', 'url'=>array('admin')),
);
?>

<h1>View BudgetTheme #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
	),
)); ?>
