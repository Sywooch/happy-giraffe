<?php
$this->breadcrumbs=array(
	'Community Rubrics'=>array(Yii::t('app', 'index')),
	Yii::t('app', 'Create'),
);

$this->menu=array(
	array('label'=>'List CommunityRubric', 'url'=>array('index')),
	array('label'=>'Manage CommunityRubric', 'url'=>array('admin')),
);
?>

<h1> Create CommunityRubric </h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'community-rubric-form',
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
