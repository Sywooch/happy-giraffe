<div class="fast-articles2_i">

    <div class="fast-articles2_header clearfix">

        <div class="meta-gray">
            <a href="<?= $b->getUrl(true) ?>" class="meta-gray_comment">
                <span class="ico-comment ico-comment__gray"></span>
                <span class="meta-gray_tx"><?= $b->commentsCount ?></span>
            </a>

            <div class="meta-gray_view">
                <span class="ico-view ico-view__gray"></span>
                <span class="meta-gray_tx"><?= PageView::model()->viewsByPath($b->url) ?></span>
            </div>
        </div>

        <div class="float-l">
            <span class="font-smallest color-gray"><?= HDate::GetFormattedTime($b->created) ?></span>
        </div>
    </div>

    <div class="fast-articles2_i-t">
        <a href="<?= $b->url ?>" class="fast-articles2_i-t-a"><?= $b->title ?></a>
        <?php if (($contestWork = $b->contestWork) !== null): ?>
            <span class="fast-articles2_i-t-count"><?=$contestWork->rate?></span>
        <?php endif; ?>
    </div>

    <div class="fast-articles2_i-desc"><?= $b->getContentText(100, '') ?></div>
    <?php if ($b->type_id == 3): ?>
        <div class="fast-articles2_i-img-hold">
            <?php $this->widget('PhotoCollectionViewWidget', array('width' => 205, 'maxHeight' => 100, 'maxRows' => 2, 'minPhotos' => 1, 'borderSize' => 1, 'collection' => new PhotoPostPhotoCollection(array('contentId' => $b->id)))); ?>
        </div>
    <?php else: ?>
        <?php $photo = $b->getPhoto() ?>
        <?php if ($photo !== null): ?>
            <div class="fast-articles2_i-img-hold">
                <a href="<?= $b->url ?>">
                    <img src="<?= $photo->getPreviewUrl(205, 300, Image::WIDTH) ?>"alt="" class="fast-articles2_i-img">
                </a>
            </div>
        <?php endif ?>
    <?php endif; ?>
</div>