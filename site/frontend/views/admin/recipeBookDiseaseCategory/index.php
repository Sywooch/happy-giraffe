<?php
$this->breadcrumbs = array(
	'Recipe Book Disease Categories',
	Yii::t('app', 'Index'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'Create') . ' RecipeBookDiseaseCategory', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' RecipeBookDiseaseCategory', 'url'=>array('admin')),
);
?>

<h1>Recipe Book Disease Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
