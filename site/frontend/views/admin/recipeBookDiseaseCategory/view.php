<?php
$this->breadcrumbs=array(
	'Recipe Book Disease Categories'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List RecipeBookDiseaseCategory', 'url'=>array('index')),
	array('label'=>'Create RecipeBookDiseaseCategory', 'url'=>array('create')),
	array('label'=>'Update RecipeBookDiseaseCategory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete RecipeBookDiseaseCategory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage RecipeBookDiseaseCategory', 'url'=>array('admin')),
);
?>

<h1>View RecipeBookDiseaseCategory #<?php echo $model->id; ?></h1>

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