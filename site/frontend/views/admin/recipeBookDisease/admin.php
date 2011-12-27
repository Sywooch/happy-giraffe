<?php
$this->breadcrumbs=array(
	'Recipe Book Diseases'=>array(Yii::t('app', 'index')),
	Yii::t('app', 'Manage'),
);

$this->menu=array(
		array('label'=>Yii::t('app',
				'List RecipeBookDisease'), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Create RecipeBookDisease'),
				'url'=>array('create')),
			);

		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('recipe-book-disease-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
		?>

<h1> Manage&nbsp;Recipe Book Diseases</h1>

<?php echo CHtml::link(Yii::t('app', 'Advanced Search'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'recipe-book-disease-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'category_id',
		'with_recipies',
		'text',
		'reasons_name',
		/*
		'symptoms_name',
		'treatment_name',
		'prophylaxis_name',
		'reasons_text',
		'symptoms_text',
		'treatment_text',
		'prophylaxis_text',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
