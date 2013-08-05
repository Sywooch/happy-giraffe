<?php

Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
Yii::app()->clientScript->registerScriptFile('/javascripts/knockout-2.2.1.js');
Yii::app()->controller->widget('site.common.extensions.imperavi-redactor-widget.ImperaviRedactorWidget', array('onlyRegisterScript' => true));

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