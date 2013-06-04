<?php
$this->breadcrumbs=array(
	'Управление счетами'=>array('index'),
	'Изменить',
);

$this->menu=array(
	array('label'=>'Список счетов', 'url'=>array('index')),
	array('label'=>'Добавить', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('billing-system-bankrequisite-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление счетами</h1>


<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'billing-system-bankrequisite-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'requisite_id',
		'requisite_name',
		'requisite_bank',
		'requisite_account',
	//	'requisite_bank_address',
		'requisite_bik',
		/*
		'requisite_cor_account',
		'requisite_inn',
		'requisite_kpp',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
