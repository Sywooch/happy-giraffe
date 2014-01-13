<?php
$this->widget('zii.widgets.CMenu', array(
    'items' => array(
        array('label' => 'Прямой эфир', 'url' => array('index')),
        array('label' => 'От старых пользователей', 'url' => array('index', 'type' => AntispamController::TYPE_OLDUSERS)),
    ),
));
?>

<?php
$this->widget('zii.widgets.CListView', array(
    'cssFile' => false,
    'ajaxUpdate' => false,
    'dataProvider' => $dp,
    'itemView' => 'site.frontend.modules.blog.views.default.view',
    'pager' => array(
        'class' => 'HLinkPager',
    ),
    'template' => '{items}
            <div class="yiipagination">
                {pager}
            </div>
        ',
    'emptyText' => '',
    'viewData' => array('full' => false),
));
?>