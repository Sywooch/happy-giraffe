<?php
    Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
?>

<div id="contents_live" class="full">
    <?php
        $this->widget('zii.widgets.CListView', array(
            'ajaxUpdate' => false,
            'dataProvider' => $live,
            'itemView' => '//community/_post',
            'template' => '{items}',
            'viewData' => array(
                'full' => false,
            ),
        ));
    ?>
</div>

<?php

    if (!Yii::app()->user->isGuest) {
        $remove_tmpl = $this->beginWidget('site.frontend.widgets.removeWidget.RemoveWidget');
        $remove_tmpl->registerTemplates();
        $this->endWidget();
    }