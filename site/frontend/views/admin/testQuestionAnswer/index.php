<?php
$this->breadcrumbs=array(
	'Test Question Answers',
);

$this->menu=array(
	array('label'=>'Create TestQuestionAnswer', 'url'=>array('create')),
	array('label'=>'Manage TestQuestionAnswer', 'url'=>array('admin')),
);
?>

<h1>Test Question Answers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
