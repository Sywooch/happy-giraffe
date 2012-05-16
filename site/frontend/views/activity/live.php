<?php

    Yii::app()->clientScript->registerMetaTag('noindex', 'robots');

    $this->widget('zii.widgets.CListView', array(
        'ajaxUpdate' => false,
        'dataProvider' => $live,
        'itemView' => '//community/_post',
        'template' => '{items}',
        'viewData' => array(
            'full' => false,
        ),
    ));

    if (!Yii::app()->user->isGuest) {
        $remove_tmpl = $this->beginWidget('site.frontend.widgets.removeWidget.RemoveWidget');
        $remove_tmpl->registerTemplates();
        $this->endWidget();
    }