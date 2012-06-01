<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'query-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
//		'id',
		'phrase',
		'visits',
//		'page_views',
		'denial',
		'depth',
		'visit_time',
        array(
            'name'=>'activePages',
            'type'=>'raw',
        ),
        array(
            'name'=>'yandexPos',
            'type'=>'raw',
        ),
        array(
            'name'=>'googlePos',
            'type'=>'raw',
        ),
	),
)); ?>
