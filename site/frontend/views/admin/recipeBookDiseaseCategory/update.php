<?php
$this->breadcrumbs=array(
	'Recipe Book Disease Categories'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('app', 'Update'),
);

$this->menu=array(
	array('label'=>'List RecipeBookDiseaseCategory', 'url'=>array('index')),
	array('label'=>'Create RecipeBookDiseaseCategory', 'url'=>array('create')),
	array('label'=>'View RecipeBookDiseaseCategory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage RecipeBookDiseaseCategory', 'url'=>array('admin')),
);
?>

<h1> Update RecipeBookDiseaseCategory #<?php echo $model->id; ?> </h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'recipe-book-disease-category-form',
	'enableAjaxValidation'=>true,
)); 
echo $this->renderPartial('_form', array(
	'model'=>$model,
	'form' =>$form
	)); ?>

<div class="row buttons">
	<?php echo CHtml::submitButton(Yii::t('app', 'Update')); ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
