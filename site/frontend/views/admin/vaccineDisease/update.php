<?php
$this->breadcrumbs=array(
	'Vaccine Diseases'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('app', 'Update'),
);

$this->menu=array(
	array('label'=>'List VaccineDisease', 'url'=>array('index')),
	array('label'=>'Create VaccineDisease', 'url'=>array('create')),
	array('label'=>'View VaccineDisease', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage VaccineDisease', 'url'=>array('admin')),
);
?>

<h1> Update VaccineDisease #<?php echo $model->id; ?> </h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vaccine-disease-form',
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
