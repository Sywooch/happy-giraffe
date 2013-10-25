<?php
$this->widget('zii.widgets.CListView', array(
    'cssFile' => false,
    'id' => 'friendsList',
    'dataProvider' => $dataProvider,
    'itemView' => '_friend',
    'template' => "{items}\n{pager}",
    'itemsTagName' => 'div',
    'htmlOptions' => array(
        'class' => 'friends-list friends-list__family margin-t20',
    ),
    'pager' => array(
        'header' => '',
        'class' => 'ext.infiniteScroll.IasPager',
        'rowSelector' => '.friends-list_i',
        'listViewId' => 'friendsList',
        'options' => array(
            'scrollContainer' => new CJavaScriptExpression("$('.layout-container')"),
            'tresholdMargin' => -250,
            'onRenderComplete' => new CJavaScriptExpression("function(items) {
                var newItems = $(items);
                $.each(newItems, function() {
                    $(this).powerTip({placement: 'n',offset: 5});
               });
            }"),
        ),
    ),
));