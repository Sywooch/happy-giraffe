<?php $this->widget('MListView', array(
    'dataProvider' => $dp,
    'itemView' => '_recipe',
    'viewData' => array(
        'full' => false,
    ),
    'pager' => array(
        'class' => 'MPager',
    ),
)); ?>