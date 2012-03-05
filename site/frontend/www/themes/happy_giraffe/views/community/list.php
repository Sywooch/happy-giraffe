<?php

$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $contents,
    'itemView' => '_post',
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

if (!empty($contents)) {
//    $this->renderPartial('parts/move_post_popup', array('c' => $contents[0]));
//    Yii::app()->clientScript->registerScript('register_after_removeContent', '
//        function CommunityContentRemove() {window.location.reload();}', CClientScript::POS_HEAD);
}