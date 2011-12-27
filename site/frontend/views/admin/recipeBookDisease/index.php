<?php
$this->breadcrumbs = array(
	'Recipe Book Diseases',
	Yii::t('app', 'Index'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'Create') . ' RecipeBookDisease', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' RecipeBookDisease', 'url'=>array('admin')),
);
?>

<h1>Recipe Book Diseases</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
