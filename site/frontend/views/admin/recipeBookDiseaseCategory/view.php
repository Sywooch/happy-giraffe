<?php
$this->breadcrumbs=array(
	'Recipe Book Disease Categories'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Все категории болезней', 'url'=>array('index')),
	array('label'=>'Создать категорию болезней', 'url'=>array('create')),
	array('label'=>'Редактировать категорию болезней', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить категорию болезней', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Управление категориями болезней', 'url'=>array('admin')),
);
?>

<h1>Категория болезней <?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>


<br /><h2> This RecipeBookDisease belongs to this RecipeBookDiseaseCategory: </h2>
<ul><?php foreach($model->diseases as $foreignobj) { 

				printf('<li>%s</li>', CHtml::link($foreignobj->name, array('recipebookdisease/view', 'id' => $foreignobj->id)));

				} ?></ul>