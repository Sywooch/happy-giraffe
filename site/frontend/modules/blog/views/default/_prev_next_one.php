<?php
/**
 * @var CommunityContent $data
 */
$photo = $data->getPhoto();
?>

<a href="<?=$data->url?>" class="article-nearby_a clearfix">
    <?php if ($photo !== null): ?>
        <span class="article-nearby_img-hold">
            <?=CHtml::image($photo->getPreviewUrl(null, 61, Image::HEIGHT), $data->title)?>
        </span>
    <?php endif; ?>
    <span class="article-nearby_tx"><?=$data->title?></span>
</a>