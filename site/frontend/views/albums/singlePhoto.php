<?php
    if (get_class($model) == 'Album')
        Yii::app()->clientScript->registerMetaTag('noindex', 'robots');

    if (false) {
        $this->widget('site.frontend.widgets.photoView.photoViewWidget', array(
            'selector' => '.count > a',
            'entity' => get_class($model),
            'entity_id' => $model->id,
            'singlePhoto' => true,
            'entity_url' => (get_class($model) == 'Contest') ? $model->url : null,
        ));
    }
?>

<div class="b-main">
    <div class="b-main_cont">
        <div class="b-main_col-hold clearfix">
            <div class="b-main_col-article">
                <div class="b-article clearfix">
                    <div class="b-article_header clearfix"></div>
                    <h1 class="b-article_t"><?=$photo->w_title?></h1>
                </div>
                <section class="b-album b-album__photolink">
                    <div href="#" class="b-album_img-hold">
                        <div class="b-album_img-a">
                            <div class="b-album_img-pad"></div>
                            <div class="b-album_img-allheight">
                                <div class="b-album_img-center">
                                    <?=CHtml::image($photo->getPreviewUrl(960, 627, Image::HEIGHT, true), $photo->w_title, array('itemprop' => 'contentURL', 'class' => 'b-album_img-big', 'title'=>$photo->w_title))?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($decor->prevLink()): ?>
                        <a href="<?= $decor->prevLink() ?>" class="i-photo-arrow i-photo-arrow__l i-photo-arrow__abs"></a>
                    <?php endif; ?>
                    <?php if ($decor->nextLink()): ?>
                        <a href="<?= $decor->nextLink() ?>" class="i-photo-arrow i-photo-arrow__r i-photo-arrow__abs"></a>
                    <?php endif; ?>
                </section>
            </div>
        </div>
    </div>
</div>
