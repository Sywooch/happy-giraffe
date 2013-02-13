<?php
    Yii::app()->clientScript
        ->registerCssFile('/stylesheets/isotope.css')
        ->registerScriptFile('/javascripts/jquery.isotope.min.js')
    ;

    $this->widget('site.frontend.widgets.photoView.photoViewWidget', array(
        'selector' => '.valentines-best_li > a',
        'entity' => 'Album',
        'entity_id' => Album::getAlbumByType(User::HAPPY_GIRAFFE, Album::TYPE_VALENTINE)->id,
    ));
?>

<script type="text/javascript">
    $(function() {
        var $container = $("#valentinesList .valentines-best_ul");

        $container.imagesLoaded(function() {
            $container.isotope({
                itemSelector : ".valentines-best_li",
                masonry: {
                    columnWidth: 234
                }
            });
        });
    });
</script>

<div class="content-cols margin-t20 clearfix">
    <div class="col-1">
        <?php $this->renderPartial('menu'); ?>
    </div>
    <div class="col-12">
        <div class="valentines-best">
            <h2 class="valentines-best_t">Лучшие валентинки</h2>
            <p class="valentines-best_p">Валентинки - это маленькие открытки, куда вписываются самые горячие признания в любви. Мы собрали для вас лучшие валентинки - вы сможете скачать их, написать свои поздравления и отправить любимым! </p>
            <?php
                $this->widget('zii.widgets.CListView', array(
                    'id' => 'valentinesList',
                    'dataProvider' => $dp,
                    'itemView' => '_valentine',
                    'template' => "<div class=\"valentines-best_hold\">{items}</div>\n{pager}",
                    'itemsTagName' => 'ul',
                    'itemsCssClass' => 'valentines-best_ul clearfix',
                    'pager' => array(
                        'class' => 'application.components.InfinitePager.InfinitePager',
                        'selector' => '#valentinesList .valentines-best_ul',
                        'options' => array(
                            'behavior' => 'local',
                            'binder' => new CJavaScriptExpression("$('.layout-container')"),
                            'itemSelector' => '.valentines-best_li',
                            'loading' => array(
                                'selector' => '.valentines-best_hold',
                            ),
                        ),
                        'callback' => new CJavaScriptExpression("function(newElements) {
                            $(newElements).imagesLoaded(function() {
                                $('#valentinesList .valentines-best_ul').isotope('appended', $(newElements));
                                " . Yii::app()->controller->pGallery . "
                            });
                        }"),
                    ),
                ));
            ?>
        </div>
    </div>
</div>