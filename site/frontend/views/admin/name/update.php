<?php
$this->breadcrumbs=array(
	'Names'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Добавить имя', 'url'=>array('create')),
	array('label'=>'Список', 'url'=>array('admin')),
);
?>

<h1>Обновить имя <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>