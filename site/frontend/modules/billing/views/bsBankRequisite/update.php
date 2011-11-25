<?php
$this->breadcrumbs=array(
	'Банковские счета'=>array('index'),
	$model->requisite_id=>array('view','id'=>$model->requisite_id),
	'Изменить',
);

$this->menu=array(
	array('label'=>'Банковские счета', 'url'=>array('index')),
	array('label'=>'Добавить', 'url'=>array('create')),
	array('label'=>'Просмотреть', 'url'=>array('view', 'id'=>$model->requisite_id)),
	array('label'=>'Управление счетами', 'url'=>array('admin')),
);
?>

<h1>Изменить параметры сёта # <?php echo $model->requisite_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>