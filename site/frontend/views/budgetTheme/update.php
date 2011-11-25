<?php
$this->breadcrumbs=array(
	'Budget Themes'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BudgetTheme', 'url'=>array('index')),
	array('label'=>'Create BudgetTheme', 'url'=>array('create')),
	array('label'=>'View BudgetTheme', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage BudgetTheme', 'url'=>array('admin')),
);
?>

<h1>Update BudgetTheme <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>