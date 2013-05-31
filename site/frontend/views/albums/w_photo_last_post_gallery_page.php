<?php
/**
 * @var CommunityContentGallery $model
 * @var AlbumPhoto $photo
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */

$content = CommunityContent::model()->full()->findByPk($model->content_id);
$more = $content->OtherCommunityGalleries();
?>
<div class="album-end">

    <div class="block-title"><?= $content->title ?></div>

    <span class="count">Вам понравился фотопост? Поделитесь с друзьями!</span>

    <div class="like-block fast-like-block">
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

    <div class="more-albums">
        <?php if (!empty($more)):?>
            <div class="block-in">
                <div class="block-title">
                    <span>Другие популярные фотопосты раздела "<?= $content->rubric->community->title ?>" </span></div>

                <div class="more-albums-photopost clearfix">
                    <ul class="more-albums-photopost_ul">

                        <?php foreach ($more as $post): ?>
                            <li class="more-albums-photopost_li">
                                <div class="more-albums-photopost_hold">
                                    <a href="<?= $post->getUrl() ?>?open_gallery=1" class="more-albums-photopost_img">
                                        <img alt="" src="<?= $post->getContentImage(220, 175, Image::WIDTH, true); ?>">
                                        <span class="more-albums-photopost_img-title"></span>
                                        <span class="more-albums-photopost_count">
                                            смотреть <span
                                                class="more-albums-photopost_count-big"><?= $post->gallery->count ?>
                                                ФОТО</span>
                                        </span>
                                        <i class="ico-play-big"></i>
                                    </a>
                                </div>
                                <a href="<?= $post->getUrl() ?>?open_gallery=1"
                                   class="more-albums-photopost_title-bottom"><?= $post->title ?></a>
                            </li>
                        <?php endforeach; ?>

                    </ul>
                </div>
            </div>
        <?php else: ?>
            <a href="javascript:void(0)" class="re-watch"><i class="icon"></i><span>Посмотреть еще раз</span></a>
        <?php endif ?>

    </div>
</div>