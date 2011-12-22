<?php
$this->breadcrumbs=array(
	'Name Famouses'=>array(Yii::t('app', 'index')),
	Yii::t('app', 'Create'),
);

$this->menu=array(
	array('label'=>'List NameFamous', 'url'=>array('index')),
	array('label'=>'Manage NameFamous', 'url'=>array('admin')),
);
?>

<h1> Create NameFamous </h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'name-famous-form',
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
