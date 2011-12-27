<?php
$this->breadcrumbs=array(
	'Recipe Book Disease Categories'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('app', 'Update'),
);

$this->menu=array(
	array('label'=>'Все категории болезней', 'url'=>array('index')),
	array('label'=>'Создать категорию болезней', 'url'=>array('create')),
	array('label'=>'Отобразить категорию болезней', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Управление категориями болезней', 'url'=>array('admin')),
);
?>

<h1>Редактировать категорию болезеней <?php echo $model->name; ?></h1>
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
