<h1>Статьи "Как выбрать"</h1>

 <?php echo CHtml::link('создать', array('create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'cook-choose-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		'category_id',
		'title',
        /*'title_accusative',
          'desc',
          'desc_quality',
          'desc_defective',
          'desc_check',
          */
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
