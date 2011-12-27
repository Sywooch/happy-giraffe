<?php
$this->breadcrumbs=array(
	'Recipe Book Diseases'=>array(Yii::t('app', 'index')),
	Yii::t('app', 'Create'),
);

$this->menu=array(
	array('label'=>'List RecipeBookDisease', 'url'=>array('index')),
	array('label'=>'Manage RecipeBookDisease', 'url'=>array('admin')),
);
?>

<h1> Create RecipeBookDisease </h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'recipe-book-disease-form',
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
