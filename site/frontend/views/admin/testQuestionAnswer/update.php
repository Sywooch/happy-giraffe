<?php
$this->breadcrumbs=array(
	'Test Question Answers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TestQuestionAnswer', 'url'=>array('index')),
	array('label'=>'Create TestQuestionAnswer', 'url'=>array('create')),
	array('label'=>'View TestQuestionAnswer', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TestQuestionAnswer', 'url'=>array('admin')),
);
?>

<h1>Update TestQuestionAnswer <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>