<?php
$this->breadcrumbs=array(
	'Vaccine Dates'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('app', 'Update'),
);

$this->menu=array(
	array('label'=>'List VaccineDate', 'url'=>array('index')),
	array('label'=>'Create VaccineDate', 'url'=>array('create')),
	array('label'=>'View VaccineDate', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage VaccineDate', 'url'=>array('admin')),
);
?>

<h1> Update VaccineDate #<?php echo $model->id; ?> </h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vaccine-date-form',
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
