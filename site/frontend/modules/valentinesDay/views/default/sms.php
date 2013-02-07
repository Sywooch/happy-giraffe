<?php
if (isset($_GET['page']) && $_GET['page'] > 0)
    Yii::app()->clientScript->registerMetaTag('noindex', 'robots');

$js = '
$("#valentine-sms").isotope({
    itemSelector : ".valentine-sms-b",
});';

Yii::app()->clientScript
    ->registerCssFile('/stylesheets/isotope.css')
    ->registerScriptFile('/javascripts/jquery.isotope.min.js')
    ->registerScript('valentine-sms', $js);

$dp = ValentineSms::model()->search();

?><div class="content-cols margin-t20 clearfix">
    <div class="col-1">
        <?php $this->renderPartial('menu'); ?>
    </div>
    <div class="col-12">
        <?php
//        $this->widget('MyListView', array(
//            'id' => 'valentine-sms',
//            'dataProvider' => $dp,
//            'itemView' => '_sms',
//            'template' => '<div class="valentine-sms">
//                <div class="valentine-sms_hold">
//                    <div class="valentine-sms_t"></div>
//                    <p class="valentine-sms_p">В день святого Валентина принято обмениваться смс о любви и маленькими
//                        подарками. Если вы еще не знаете, как поздравить с днем святого Валентина свою вторую половинку -
//                        пришлите ей смс с признанием в любви.</p>
//                </div>
//                <div id="valentine-sms">{items}</div>
//            </div>{pager}',
//            'itemsTagName' => 'ul',
//            'htmlOptions' => array(
//                'class' => 'masonry-news-list',
//            ),
//            'viewData' => array(
//                'page' => $dp->pagination->currentPage,
//                'listView' => true,
//            ),
//            'pager' => array(
//                'class' => 'AlbumLinkPager',
//                'selector' => '#valentine-sms .items',
//                'options' => array(
//                    'behavior' => 'local',
//                    'binder' => new CJavaScriptExpression("$('.layout-container')"),
//                    'itemSelector' => '.masonry-news-list_item',
//                ),
//                'callback' => new CJavaScriptExpression("function(newElements) {
//                        $(newElements).imagesLoaded(function() {
//                            $('#valentine-sms .items').isotope('appended', $(newElements));
//                        });
//                    }"),
//            ),
//        ));
        ?>

        <div class="valentine-sms">
            <div class="valentine-sms_hold">
                <div class="valentine-sms_t"></div>
                <p class="valentine-sms_p">В день святого Валентина принято обмениваться смс о любви и маленькими
                    подарками. Если вы еще не знаете, как поздравить с днем святого Валентина свою вторую половинку -
                    пришлите ей смс с признанием в любви.</p>
            </div>
            <div id="valentine-sms">
            <?php foreach ($models as $model): ?>
                <div class="valentine-sms-b valentine-sms-b__withe">
                    <span class="valentine-sms-b_t">«<?=$model->title ?>»</span>
                    <span class="valentine-sms-b_p"><?=$model->getFormattedText() ?></span>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
        <?php if ($pages !== null): ?>
        <?php if ($pages->pageCount > 1): ?>
            <div class="pagination pagination-center clearfix">
                <?php $this->widget('AlbumLinkPager', array('pages' => $pages)); ?>
            </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>