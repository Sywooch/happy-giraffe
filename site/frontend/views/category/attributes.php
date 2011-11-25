<?php echo CHtml::beginForm(array('attributeInSearch','id'=>$category->category_id)); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-attribute-grid',
	'dataProvider'=>$model->search($criteria),
	'filter'=>$model,
	'columns'=>array(
		'attribute_id',
		'attribute_title',
		'attribute_text',
		array(
			'name'=>'type',
			'filter'=>$model->types->statuses,
		),
//		'attribute_required',
		array(
			'name'=>'categoryInSearch',
			'value'=>'$data->getCategoryInSearch('.$category->category_id.')',
			'type'=>'boolean',
			'filter'=>false,
		),
		array(
			'class'=>'CCheckBoxColumn',
			'checked'=>'$data->getCategoryInSearch('.$category->category_id.')',
			'header'=>'В поиск',
			'checkBoxHtmlOptions'=>array(
				'name'=>'insearch[]',
			),
			'footer'=>'<input type="submit" value="submit">',
			'selectableRows'=>2,
		),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{addsearch} {remsearch} {delete}',
			'deleteButtonUrl'=>'array("unconnectAttribute","id"=>$data->attribute_id,"categiry_id"=>'.$category->category_id.')',
			
			'buttons'=>array(
				'addsearch'=>array(
					'label'=>'Add in search',
					'imageUrl'=>'/shop/images/addsearch.png',
					'url'=>'array("addAttributeInSearch","id"=>$data->attribute_id,"categiry_id"=>'.$category->category_id.')',
					'visible'=>'!$data->getCategoryInSearch('.$category->category_id.')',//string
				),
				'remsearch'=>array(
					'label'=>'Remove from search',
					'imageUrl'=>'/shop/images/remsearch.png',
					'url'=>'array("remAttributeInSearch","id"=>$data->attribute_id,"categiry_id"=>'.$category->category_id.')',
					'visible'=>'$data->getCategoryInSearch('.$category->category_id.')',//string
				),
			),
		),
	),
)); ?>

<?php echo CHtml::endForm(); ?>