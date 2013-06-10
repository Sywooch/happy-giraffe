<?php
/**
 * @var CommunityContentGallery $model
 * @var AlbumPhoto $photo
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */

$content = CommunityContent::model()->full()->findByPk($model->content_id);
$more = $content->OtherCommunityGalleries(2);
?>
<div class="album-end">

    <div class="album-end_t">
        <span class="album-end_t-tx"><?=$content->title?></span>

        <a href="javascript:void(0)" class="re-watch album-end_rewatch">
            <span class="album-end_rewatch-tx">Посмотреть еще раз</span>
        </a>
    </div>

    <span class="album-end_like-t">Вам понравился фотопост?  Поделитесь с друзьями!  </span>

    <noindex>
        <?php $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
            'model' => $content,
            'type' => 'simple_ajax',
            'url' => $content->getUrl(false, true),
            'options' => array(
                'title' => $content->title,
                'image' => $content->getContentImage(400),
                'description' => $content->getContent()->text,
            ),
        )); ?>
    </noindex>
</div>

<?php if ($more): ?>
    <div class="more-albums-photopost">
        <ul class="more-albums-photopost_ul clearfix">
            <?php foreach ($more as $post): ?>
            <li class="more-albums-photopost_li">
                <div class="more-albums-photopost_hold">
                    <a href="<?=$post->getUrl()?>?open_gallery=1" class="more-albums-photopost_img">
                        <img alt="" src="<?=$post->gallery->items[0]->photo->getPreviewUrl(440, 341, Image::INVERT, true)?>">
                                            <span class="more-albums-photopost_img-title">
                                                <span class="more-albums-photopost_img-title-tx"><?=$post->title?></span>
                                            </span>
                                            <span class="more-albums-photopost_count">
                                                смотреть <span class="more-albums-photopost_count-big"><?=$post->gallery->count?> ФОТО</span>
                                            </span>
                        <i class="ico-play-big"></i>
                    </a>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>