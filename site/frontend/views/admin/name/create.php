<?php
$this->breadcrumbs=array(
	'Names'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('admin')),
);
?>

<h1>Добавить имя</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>