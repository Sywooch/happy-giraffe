<?php
$this->breadcrumbs=array(
	'Budget Themes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BudgetTheme', 'url'=>array('index')),
	array('label'=>'Manage BudgetTheme', 'url'=>array('admin')),
);
?>

<h1>Create BudgetTheme</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>