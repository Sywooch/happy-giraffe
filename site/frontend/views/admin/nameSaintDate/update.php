<?php
$this->breadcrumbs=array(
	'Name Saint Dates'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('app', 'Update'),
);

$this->menu=array(
	array('label'=>'List NameSaintDate', 'url'=>array('index')),
	array('label'=>'Create NameSaintDate', 'url'=>array('create')),
	array('label'=>'View NameSaintDate', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage NameSaintDate', 'url'=>array('admin')),
);
?>

<h1> Update NameSaintDate #<?php echo $model->id; ?> </h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'name-saint-date-form',
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
