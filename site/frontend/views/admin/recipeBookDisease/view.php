<?php
$this->breadcrumbs=array(
	'Recipe Book Diseases'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Все болезни', 'url'=>array('index')),
	array('label'=>'Создать болезнь', 'url'=>array('create')),
	array('label'=>'Редактировать болезнь', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить болезнь', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Управление болезнями', 'url'=>array('admin')),
);
?>

<h1>Болезнь <?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'category.name',
		'with_recipies',
		'text',
		'reasons_name',
		'symptoms_name',
		'treatment_name',
		'prophylaxis_name',
		'reasons_text',
		'symptoms_text',
		'treatment_text',
		'prophylaxis_text',
	),
)); ?>


<br /><h2> This RecipeBookRecipe belongs to this RecipeBookDisease: </h2>
<ul><?php foreach($model->recipes as $foreignobj) { 

				printf('<li>%s</li>', CHtml::link($foreignobj->name, array('recipebookrecipe/view', 'id' => $foreignobj->id)));

				} ?></ul>