<?php
$this->breadcrumbs=array(
	'Vaccines'=>array(Yii::t('app', 'index')),
	Yii::t('app', 'Create'),
);

$this->menu=array(
	array('label'=>'List Vaccine', 'url'=>array('index')),
	array('label'=>'Manage Vaccine', 'url'=>array('admin')),
);
?>

<h1> Create Vaccine </h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vaccine-form',
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
