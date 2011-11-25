<?php
$this->breadcrumbs=array(
	'Категории'=>array('admin'),
	'Администрирование',
);

$this->menu=array(
	array('label'=>'Создать категорию', 'url'=>array('root')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('category-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Администрирование</h1>

<?php echo CHtml::link('Поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php
//$this->widget('zii.widgets.grid.CGridView', array(
$this->widget('ext.QTreeGridView.CQTreeGridView', array(
	'id'=>'category-grid',
	'ajaxUpdate' => false,
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'category_id',
//		'category_root',
//		'category_level',
//		'category_lft',
//		'category_rgt',
		array(
			'name'=>'category_name',
			'value'=>'$data->nameExt',
		),
		'category_title',
		'category_keywords',
		/*
		'category_text',
		'category_description',
		*/
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view} {up} {down} {sub} {update} {delete}',
			'buttons' => array(
				'up' => array(
					'label' => 'Выше',
					'imageUrl' => '/shop/images/up.png',
					'url' => 'array("up","id"=>$data->category_id)',
				),
				'down' => array(
					'label' => 'Ниже',
					'imageUrl' => '/shop/images/down.png',
					'url' => 'array("down","id"=>$data->category_id)',
				),
				'sub' => array(
					'label' => 'Создать подкатегорию',
					'imageUrl' => '/shop/images/plus.png',
					'url' => 'array("create","id"=>$data->category_id)',
				),
			),
		),
	),
)); ?>
