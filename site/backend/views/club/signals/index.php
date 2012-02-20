<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'user-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'id',
        'user_id',
        'type',
        'item_name',
       'item_id',
    ),
)); ?>

