<?php
    $channel = 'whatsNewIndex';

    Yii::app()->clientScript
        ->registerCssFile('/stylesheets/user.css')
        ->registerCssFile('/stylesheets/isotope.css')
        ->registerScriptFile('/javascripts/jquery.isotope.min.js')
        ->registerScriptFile('/javascripts/live.js')
        ->registerScript('Realplexor-reg-whatsNew', 'comet.connect(\'http://' . Yii::app()->comet->host . '\', \'' . Yii::app()->comet->namespace . '\', \'' . $channel . '\');')
    ;

    Yii::app()->eauth->renderWidget(array(
        'mode' => 'assets',
    ));
?>

<div id="broadcast" class="broadcast-all">

    <?php $this->renderPartial('/menu'); ?>

    <div class="content-cols clearfix">

        <?php
            $this->widget('zii.widgets.CListView', array(
                'id' => 'liveList',
                'dataProvider' => $dp,
                'itemView' => '_brick',
                'template' => "{items}\n{pager}",
                'itemsTagName' => 'ul',
                'htmlOptions' => array(
                    'class' => 'masonry-news-list',
                ),
                'viewData' => array(
                    'page' => $dp->pagination->currentPage,
                    'listView' => true,
                ),
                'pager' => array(
                    'header' => '',
                    'class' => 'ext.infiniteScroll.IasPager',
                    'rowSelector' => '.masonry-news-list_item',
                    'listViewId' => 'liveList',
                    'options' => array(
                        'scrollContainer' => new CJavaScriptExpression("$('.layout-container')"),
                        'tresholdMargin' => -250,
                        'onRenderComplete' => new CJavaScriptExpression("function(items) {
                            var newItems = $(items);

                            newItems.hide().imagesLoaded(function() {
                                newItems.show();
                                $('#liveList .items').isotope('appended', newItems);
                            });
                        }"),
                    ),
                ),
            ));
        ?>

    </div>

</div>

