<?php
$this->breadcrumbs=array(
	'Vaccine Diseases'=>array(Yii::t('app', 'index')),
	Yii::t('app', 'Create'),
);

$this->menu=array(
	array('label'=>'List VaccineDisease', 'url'=>array('index')),
	array('label'=>'Manage VaccineDisease', 'url'=>array('admin')),
);
?>

<h1> Create VaccineDisease </h1>
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
	<?php echo CHtml::submitButton(Yii::t('app', 'Create')); ?>
</div>

<?php $this->endWidget(); ?>

</div>
