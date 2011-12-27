<?php
$this->breadcrumbs=array(
	'Recipe Book Diseases'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('app', 'Update'),
);

$this->menu=array(
	array('label'=>'Все болезни', 'url'=>array('index')),
	array('label'=>'Создать болезнь', 'url'=>array('create')),
	array('label'=>'Отобразить болезнь', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Управление болезнями', 'url'=>array('admin')),
);
?>

<h1>Редактировать болезнь <?php echo $model->name; ?></h1>
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
	<?php echo CHtml::submitButton(Yii::t('app', 'Update')); ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
