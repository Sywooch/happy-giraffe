<?php
$this->breadcrumbs=array(
	'Бренды'=>array('admin'),
	'Администрирование',
);

$this->menu=array(
	array('label'=>'Создать', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('product-brand-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Администрирование</h1>

<?php echo CHtml::link('Расширенный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
));
?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-brand-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'brand_id',
		array(
			'name'=>'brand_image',
			'value'=>'$data->brand_image->getUrl()',
			'type'=>'image',
			'filter'=>false,
		),
		'brand_title',
		array(
			'name'=>'brand_text',
			'type'=>'ntext',
		),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update} {delete}',
		),
	),
)); ?>
