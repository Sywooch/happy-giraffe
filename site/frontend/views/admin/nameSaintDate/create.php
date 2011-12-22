<?php
$this->breadcrumbs=array(
	'Name Saint Dates'=>array(Yii::t('app', 'index')),
	Yii::t('app', 'Create'),
);

$this->menu=array(
	array('label'=>'List NameSaintDate', 'url'=>array('index')),
	array('label'=>'Manage NameSaintDate', 'url'=>array('admin')),
);
?>

<h1> Create NameSaintDate </h1>
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
	<?php echo CHtml::submitButton(Yii::t('app', 'Create')); ?>
</div>

<?php $this->endWidget(); ?>

</div>
