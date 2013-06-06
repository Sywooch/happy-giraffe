<div id="photo-window-in">

    <div class="photo-bg">

        <div class="top-line clearfix">

            <a onclick="$.fancybox.close();" href="javascript:void(0);" class="close"></a>

            <div class="user">
                <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                    'user' => $photo->author,
                    'size' => 'small',
                    'sendButton' => false,
                    'location' => false
                )); ?>
            </div>

            <div class="photo-info photo-container">
                <?php $this->widget('FavouriteWidget', array('model' => $photo)); ?>

                <a id="gallery-top-link" href="#gallery-top" style="display:none !important;"></a>
                <?=$title?><?php if (get_class($model) != 'Contest'): ?> - <span class="count"><span><?=($currentIndex + 1)?></span> фото из <?=$count?></span><?php endif; ?>
                <div id="gallery-top" class="title"><?=$photo->w_title?></div>
            </div>

        </div>

        <div id="photo" class="photo-container">

            <div class="img">
                <table><tr><td><?=CHtml::image($photo->getPreviewUrl(960, 627, Image::HEIGHT), '')?></td></tr></table>
            </div>

            <a href="javascript:void(0)" class="prev"><i class="icon"></i>предыдушая</a>
            <a href="javascript:void(0)" class="next"><i class="icon"></i>следующая</a>

        </div>

        <div class="photo-comment photo-container"">
        <p><?=$photo->w_description?></p>
    </div>

    <div class="rewatch-container" style="display: none;"><?php
        if ($photo->galleryItem)
            $this->renderPartial('w_photo_last_post_gallery_page', compact('model', 'photo'));
        elseif (empty($photo->album->type) || $photo->album->type == Album::TYPE_PRIVATE || $photo->album->type == Album::TYPE_FAMILY)
            $this->renderPartial('w_photo_last_album_page', compact('more', 'count', 'title'));
        ?></div>

</div>

<div id="w-photo-content" class="photo-container">
    <?php $this->renderPartial('w_photo_content', compact('model', 'photo')); ?>
</div>

</div>