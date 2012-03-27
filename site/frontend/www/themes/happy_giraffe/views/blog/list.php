<?php

$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $contents,
    'itemView' => '/community/_post',
    'summaryText' => 'Показано: {start}-{end} из {count}',
    'pager' => array(
        'class' => 'MyLinkPager',
        'header' => 'Страницы',
    ),
    'template' => '{items}
        <div class="pagination pagination-center clearfix">
            {summary}
            {pager}
        </div>
    ',
    'viewData' => array(
        'full' => false,
    ),
));

if (!Yii::app()->user->isGuest) {
    $remove_tmpl = $this->beginWidget('site.frontend.widgets.removeWidget.RemoveWidget');
    $remove_tmpl->registerTemplates();
    $this->endWidget();
}