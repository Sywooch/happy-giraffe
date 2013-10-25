<h1>Manage Community Photo Posts</h1>

 <?php echo CHtml::link('создать', array('CommunityMorningPost/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'community-photo-post-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'location',
		'location_image',
		'content_id',
		'is_published',
        /*
          'lat',
          'long',
          'zoom',
          */
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
