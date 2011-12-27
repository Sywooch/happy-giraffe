<?php
$this->breadcrumbs=array(
	'Recipe Book Disease Categories'=>array(Yii::t('app', 'index')),
	Yii::t('app', 'Create'),
);

$this->menu=array(
	array('label'=>'Все категории болезней', 'url'=>array('index')),
	array('label'=>'Управление категориями болезней', 'url'=>array('admin')),
);
?>

<h1>Создать категорию болезней</h1>
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
