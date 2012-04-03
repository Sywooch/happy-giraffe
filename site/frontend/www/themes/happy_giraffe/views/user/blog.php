<?php

$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $contents,
    'itemView' => 'webroot.themes.happy_giraffe.views.community._post',
    //'summaryText' => 'Показано: {start}-{end} из {count}',
    'pager' => array(
        'class' => 'MyLinkPager',
        'header' => '',
    ),
    'template' => '{items}
        <div class="pagination pagination-center clearfix">
            {pager}
        </div>
    ',
    'viewData' => array(
        'full' => false,
    ),
));

$remove_tmpl = $this->beginWidget('site.frontend.widgets.removeWidget.RemoveWidget');
$remove_tmpl->registerTemplates();
$this->endWidget();

