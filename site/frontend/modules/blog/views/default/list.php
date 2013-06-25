<?php

Yii::app()->clientScript->registerMetaTag('noindex', 'robots');

$this->widget('zii.widgets.CListView', array(
    'cssFile' => false,
    'ajaxUpdate' => false,
    'dataProvider' => $contents,
    'itemView' => 'view',
    'pager' => array(
        'class' => 'HLinkPager',
    ),
    'template' => '{items}
        <div class="yiipagination">
            {pager}
        </div>
    ',
    'viewData' => array('full' => false),
));