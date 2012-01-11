<?php
$this->breadcrumbs=array(
	'Test Question Answers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TestQuestionAnswer', 'url'=>array('index')),
	array('label'=>'Manage TestQuestionAnswer', 'url'=>array('admin')),
);
?>

<h1>Create TestQuestionAnswer</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>