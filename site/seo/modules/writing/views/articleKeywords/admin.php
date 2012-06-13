<h1>Manage Article Keywords</h1>

 <?php echo CHtml::link('создать', array('ArticleKeywords/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'article-keywords-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		//'entity',
		'entity_id',
		array(
		    'name'=>'url',
            'type'=>'raw',
            'value'=>'$data->getArticleLink()',
        ),
        array(
            'name'=>'keyword_group_id',
            'type'=>'raw',
		    'value'=>'$data->keyword_group_id."  ".$data->getKeywords()',
		),
		'number',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>

<style type="text/css">
    #article-keywords-grid_c0, #article-keywords-grid_c1, #article-keywords-grid_c4{
        width: 50px;
    }
</style>