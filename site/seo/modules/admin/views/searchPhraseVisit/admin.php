<h1>Manage Search Phrase Visits</h1>

 <?php echo CHtml::link('создать', array('/admin/SearchPhraseVisit/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'search-phrase-visit-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array(
		    'name'=>'search_phrase_id',
		    'value'=>'$data->phrase->keyword->name."  ".$data->search_phrase_id',
		),
        array(
            'name' => 'se_id',
            'value' => '$data->getSe()',
            'filter' => array(2 => 'yandex', 3 => 'google')
        ),
		'visits',
		'week',
		'year',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
