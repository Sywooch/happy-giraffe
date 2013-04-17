<?php

    Yii::app()->clientScript->registerMetaTag('noindex', 'robots');

    $this->widget('zii.widgets.CListView', array(
        'cssFile'=>false,
        'ajaxUpdate' => false,
        'dataProvider' => $contents,
        'itemView' => '_post',
        'summaryText' => 'Показано: {start}-{end} из {count}',
        'pager' => array(
            'class' => 'AlbumLinkPager',
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

    if (!Yii::app()->user->isGuest) {
        $remove_tmpl = $this->beginWidget('site.frontend.widgets.removeWidget.RemoveWidget');
        $remove_tmpl->registerTemplates();
        $this->endWidget();
    }