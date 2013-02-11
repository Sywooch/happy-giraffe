<?php $this->widget('MListView', array(
    'dataProvider' => $dp,
    'itemView' => '_post',
    'pager' => array(
        'class' => 'MPager',
    ),
)); ?>