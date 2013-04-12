<?php $this->controller->beginWidget('SeoContentWidget'); ?>
<div class="broadcast-widget">
    <div class="broadcast-title-box">
        <div class="title">
            <span class="icon-boradcast-small" ></span> Что нового у меня
        </div>
    </div>

    <?php
    $this->widget('zii.widgets.CListView', array(
        'cssFile'=>false,
        'id' => 'whatsNewUserWidgetList',
        'dataProvider' => $dp,
        'itemView' => 'application.modules.whatsNew.views.friends._noname_brick',
        'template' => "{items}\n{pager}",
        'itemsTagName' => 'ul',
        'htmlOptions' => array(
            'class' => 'masonry-news-list',
        ),
        'pager' => array(
            'header' => '',
            'class' => 'ext.infiniteScroll.IasPager',
            'rowSelector' => '.masonry-news-list_item',
            'listViewId' => 'whatsNewUserWidgetList',
            'options' => array(
                'scrollContainer' => new CJavaScriptExpression("$('.layout-container')"),
                'onRenderComplete' => new CJavaScriptExpression("function(items) {
                        var newItems = $(items);

                        newItems.hide().imagesLoaded(function() {
                            newItems.show();
                            $('#whatsNewUserWidgetList .items').isotope('appended', newItems);
                        });
                    }"),
            ),
        ),
    ));
    ?>

</div>
<?php $this->controller->endWidget(); ?>