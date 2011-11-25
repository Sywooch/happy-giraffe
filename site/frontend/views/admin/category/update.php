<?php
$this->breadcrumbs=array(
	'Категории'=>array('admin'),
	$model->category_name=>array('view','id'=>$model->category_id),
	'Редактировать',
);

$this->menu=array(
	array('label'=>'Показать', 'url'=>array('view', 'id'=>$model->category_id)),
	array('label'=>'Добавить атрибуты', 'url'=>array('connectAttributes', 'id'=>$model->category_id)),
	array('label'=>'Администрирование', 'url'=>array('admin')),
);
?>

<h1>Редактировать <?php echo $model->category_name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>