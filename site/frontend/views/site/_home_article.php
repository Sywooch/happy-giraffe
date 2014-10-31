<div class="article-similar article-similar__<?= $color ?>">
    <div class="article-similar_row">
        <a href="<?=$model->author->url ?>" class="article-similar_header-a">
            <? $this->widget('Avatar', array('user' => $model->author, 'tag' => 'span', 'size' => 40)) ?>
            <span class="article-similar_author"> <?=$model->author->fullName ?></span>
        </a>
    </div>
    <div class="article-similar_row"><a href="<?= $model->url ?>" class="article-similar_t"><?= $model->title ?></a></div>
    <?php if ($model->type_id == CommunityContent::TYPE_POST): ?>
        <?php if (($photo = $model->getPhoto()) !== null): ?>
            <div class="article-similar_img-hold">
                <?= CHtml::image($photo->getPreviewUrl(240, null, Image::WIDTH), $photo->title, array('class' => 'article-similar_img')) ?>
            </div>
        <?php elseif ($model->getAttributePhotoCollection('preview', false) && $model->getAttributePhotoCollection('preview')->attachesCount > 0): ?>
            <div class="article-similar_img-hold">
                <?= CHtml::image(\Yii::app()->thumbs->getThumb($model->getAttributePhotoCollection('preview')->attaches[0]->photo, 'postPreviewSmall')->getUrl(), $model->getAttributePhotoCollection('preview')->attaches[0]->photo->title, array('class' => 'content-ing')) ?>
            </div>
        <?php else: ?>
            <div class="article-similar_text">
                <p><?= $model->getContentText(256) ?></p>
            </div>
        <?php endif; ?>
    <?php elseif ($model->type_id == CommunityContent::TYPE_VIDEO): ?>
        <div class="article-similar_img-hold">
            <div class="video-container">
                <?= $model->video->embed ?>
            </div>
        </div>
    <?php elseif ($model->type_id == CommunityContent::TYPE_PHOTO_POST): ?>
        <div class="article-similar_img-hold">
            <div class="article-similar_count-hold">
                <!-- КОличество фото в фотопосте -->
                <?= $model->getPhoto() ?>
                <div class="article-similar_count-t"> </div>
                <div class="article-similar_count-tx">фото</div>
            </div>

            <?php $this->widget('PhotoCollectionViewWidget', array('width' => 240, 'maxHeight' => 100, 'borderSize' => 1, 'href' => $model->url, 'maxRows' => 3, 'minPhotos' => 1, 'collection' => new PhotoPostPhotoCollection(array('contentId' => $model->id)))); ?>
        </div>
    <?php endif; ?>
</div>
