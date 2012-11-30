<?php
    Yii::app()->clientScript
        ->registerCssFile('/stylesheets/user.css')
        ->registerScriptFile('/javascripts/jquery.masonry.min.js')
        ->registerScriptFile('/javascripts/live.js')
        ->registerScript('Realplexor-reg-whatsNew', 'comet.connect(\'http://' . Yii::app()->comet->host . '\', \'' . Yii::app()->comet->namespace . '\', \'whatsNewIndex\');')
    ;

    Yii::app()->eauth->renderWidget(array(
        'mode' => 'assets',
    ));
?>

<div id="broadcast" class="broadcast-all">

    <?php $this->renderPartial('menu'); ?>

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

</div>

