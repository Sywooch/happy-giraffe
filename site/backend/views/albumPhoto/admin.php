<h1>Manage Album Photos</h1>

 <?php echo CHtml::link('создать', array('AlbumPhoto/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'album-photo-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'author_id',
		'album_id',
		'file_name',
		'fs_name',
		'title',
		/*
		'updated',
		'created',
		'removed',
		*/
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
