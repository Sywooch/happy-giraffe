<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'query-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
//		'id',
        'phrase',
        array(
            'name'=>'activePages',
            'type'=>'raw',
        ),
        array(
            'name'=>'yandexPos',
            'type'=>'raw',
            'sortable'=>true
        ),
        array(
            'name'=>'googlePos',
            'type'=>'raw',
            'sortable'=>true
        ),
        'visits',
//		'page_views',
        'denial',
        'depth',
        'visit_time',
    ),
)); ?>
