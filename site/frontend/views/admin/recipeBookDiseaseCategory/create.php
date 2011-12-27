<?php
$this->breadcrumbs=array(
	'Recipe Book Disease Categories'=>array(Yii::t('app', 'index')),
	Yii::t('app', 'Create'),
);

$this->menu=array(
	array('label'=>'List RecipeBookDiseaseCategory', 'url'=>array('index')),
	array('label'=>'Manage RecipeBookDiseaseCategory', 'url'=>array('admin')),
);
?>

<h1> Create RecipeBookDiseaseCategory </h1>
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
	<?php echo CHtml::submitButton(Yii::t('app', 'Create')); ?>
</div>

<?php $this->endWidget(); ?>

</div>
