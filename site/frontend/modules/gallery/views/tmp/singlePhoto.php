<?php
/**
 * @var PhotoCollection $collection
 * @var AlbumPhoto $photo
 * @var $photoCollectionElement
 * @var string $nextPhotoUrl
 * @var string $prevPhotoUrl
 */
if (false) {
    Yii::app()->clientScript->registerPackage('gallery');
}
?>

<div class="b-main">
    <div class="b-main_cont">
        <div class="b-main_col-hold clearfix">
            <div class="b-main_col-article">
                <div class="b-article clearfix">
                    <div class="b-article_header clearfix">
                        <div class="float-l">
                            <?php $this->widget('Avatar', array('user' => $photo->author)); ?>
                            <div class="b-article_author"><a href="<?=$photo->author->getUrl()?>" class="a-light"><?=$photo->author->getFullName()?></a></div>
                        </div>
                    </div>
                    <h1 class="b-article_t"><?=$photoCollectionElement['title']?></h1>
                </div>
                <section class="b-album b-album__photolink">
                    <div href="#" class="b-album_img-hold">
                        <div class="b-album_img-a">
                            <div class="b-album_img-pad"></div>
                            <div class="b-album_img-allheight">
                                <div class="b-album_img-center">
                                    <?=CHtml::image($photo->getPreviewUrl(680, null, Image::WIDTH), $photo->w_title, array('class' => 'b-album_img-big', 'title'=>$photo->w_title))?>
                                </div>
                            </div>
                        </div>
                    </div>
                        <?php if ($nextPhotoUrl): ?>
                            <a href="<?= $nextPhotoUrl ?>" class="i-photo-arrow i-photo-arrow__l i-photo-arrow__abs"></a>
                        <?php endif; ?>
                        <?php if ($nextPhotoUrl): ?>
                            <a href="<?= $nextPhotoUrl ?>" class="i-photo-arrow i-photo-arrow__r i-photo-arrow__abs"></a>
                        <?php endif; ?>
                </section>
            </div>
        </div>
    </div>
</div>
