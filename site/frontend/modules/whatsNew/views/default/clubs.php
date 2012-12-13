<?php
    $js = '
            var $container = $("#liveList .items");

            $container.imagesLoaded(function() {
                $container.isotope({
                    itemSelector : ".masonry-news-list_item"
                });
            });
        ';

    Yii::app()->clientScript
        ->registerCssFile('/stylesheets/user.css')
        ->registerCssFile('/stylesheets/isotope.css')
        ->registerScriptFile('/javascripts/jquery.isotope.min.js')
        ->registerScript('whatsNew-isotope', $js)
    ;

    Yii::app()->eauth->renderWidget(array(
        'mode' => 'assets',
    ));
?>

<div id="broadcast">

    <?php $this->renderPartial('/menu'); ?>

    <div class="content-cols clearfix">

        <div class="col-12">
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
                    'pager' => array(
                        'header' => '',
                        'class' => 'ext.infiniteScroll.IasPager',
                        'rowSelector' => 'li',
                        'listViewId' => 'liveList',
                        'options' => array(
                            'scrollContainer' => new CJavaScriptExpression("$('.layout-container')"),
                            'onLoadItems' => new CJavaScriptExpression("function(items) {
                                $(items).hide();
                                $('#liveList .items').append(items).imagesLoaded(function() {
                                     $('#liveList .items').masonry('appended', $(items));
                                     $(items).fadeIn();
                                });
                                return false;
                            }"),
                        ),
                    ),
                ));
            ?>
        </div>

        <div class="col-3 clearfix">
            <?php if ($this->beginCache('bestUsers-clubs', array('duration' => 600))): ?>
                <?php $this->widget('ActiveUsersWidget', array(
                    'type' => ActiveUsersWidget::TYPE_CLUBS,
                )); ?>
            <?php $this->endCache(); endif; ?>
        </div>

    </div>

</div>

