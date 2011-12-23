<?php
$this->breadcrumbs=array(
	'Name Groups'=>array(Yii::t('app', 'index')),
	Yii::t('app', 'Create'),
);

$this->menu=array(
	array('label'=>'List NameGroup', 'url'=>array('index')),
	array('label'=>'Manage NameGroup', 'url'=>array('admin')),
);
?>

<h1> Create NameGroup </h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'name-group-form',
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
