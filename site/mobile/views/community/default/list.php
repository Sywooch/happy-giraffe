<?php $this->widget('MListView', array(
    'dataProvider' => $dp,
    'itemView' => '/_post',
    'viewData' => array(
        'full' => false,
    ),
    'pager' => array(
        'class' => 'MPager',
    ),
)); ?>