<?php
$this->breadcrumbs=array(
	'Банковские счета'=>array('index'),
	'Добавить',
);

$this->menu=array(
	array('label'=>'Список счетов', 'url'=>array('index')),
	array('label'=>'Управление счетами', 'url'=>array('admin')),
);
?>

<h1>Добавить банковский счёт</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>