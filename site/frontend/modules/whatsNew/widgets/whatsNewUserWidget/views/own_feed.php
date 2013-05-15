<?php $this->controller->beginWidget('SeoContentWidget'); ?>
<div class="broadcast-widget">
    <div class="broadcast-title-box">
        <ul class="broadcast-widget-menu-r">
            <li>
                <a href="<?=Yii::app()->createUrl('/whatsNew/default/index')?>"><span class="icon-boradcast-small" ></span>В прямом эфире</a>
            </li>
            <li>
                <a href="<?=Yii::app()->createUrl('/whatsNew/default/clubs')?>">В клубах</a>
            </li>
            <li>
                <a href="<?=Yii::app()->createUrl('/whatsNew/default/blogs')?>">В блогах</a>
            </li>
        </ul>

        <div class="title">
            <span class="icon-boradcast-small" ></span> Что нового у моих друзей
        </div>
    </div>

    <?php
        $t = microtime(true);
        $this->widget('zii.widgets.CListView', array(
            'cssFile'=>false,
            'id' => 'whatsNewUserWidgetList',
            'dataProvider' => $dp,
            'itemView' => 'application.modules.whatsNew.views.friends._brick',
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
    <span style="display: none;"><?= (microtime(true) - $t) ?></span>

</div>
<?php $this->controller->endWidget(); ?>