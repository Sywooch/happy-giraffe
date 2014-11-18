<div class="article-banner">
<?php
if (Yii::app()->controller instanceof LiteController) {
    $this->widget('AdsWidget', array(
        'dummyTag' => 'adfox',
        'responsiveConfig' => array(
            AdsWidget::VERSION_TABLET => 'adfox/680x470',
            AdsWidget::VERSION_DESKTOP => 'adfox/680x470',
        ),
    ));
} else {
    $this->beginWidget('AdsWidget', array(
        'dummyTag' => 'adfox',
    ));
    echo $this->renderPartial('site.frontend.widgets.views.ads.adfox.680x470');
    $this->endWidget();
}
?>
</div>