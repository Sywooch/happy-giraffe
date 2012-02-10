<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'user-list-grid',
    'dataProvider' => $dataProvider,
    'afterAjaxUpdate' => 'function() {$("#user-list-select-all").removeAttr("checked");}',
    'columns' => array(
        array(
            'class'=>'CCheckBoxColumn',
            'selectableRows' => 2,
            'checkBoxHtmlOptions' => array(
                'name' => 'user-list-check[]'
            ),
        ),
        'id',
        'nick'
    )
)); ?>