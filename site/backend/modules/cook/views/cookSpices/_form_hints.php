<?php
$dataProvider = new CActiveDataProvider ('CookSpicesHints',
    array(
        'criteria' => array('condition' => 'spice_id = ' . $model->id, 'order' => 'id'),
        'pagination' => array('pageSize' => 100)
    )
);

$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_hint'
));
