<h1>Manage Pages Search Phrases</h1>

 <?php echo CHtml::link('создать', array('/admin/PagesSearchPhrase/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'pages-search-phrase-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array(
		    'name'=>'page_id',
		    'value'=>'CHtml::link($data->page_id, Yii::app()->createUrl("/admin/page/update/", array("id"=>$data->page_id)))."  ".$data->page->url',
            'type'=>'raw'
		),
		array(
		    'name'=>'keyword_id',
		    'value'=>'$data->keyword->name."  ".$data->keyword_id',
		),
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
));