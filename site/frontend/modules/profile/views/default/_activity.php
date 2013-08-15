<?php
Yii::app()->clientScript->registerPackage('ko_blog');
$this->widget('zii.widgets.CListView', array(
    'cssFile' => false,
    'ajaxUpdate' => false,
    'dataProvider' => $user->getActivityDataProvider(),
    'itemView' => 'blog.views.default.view',
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