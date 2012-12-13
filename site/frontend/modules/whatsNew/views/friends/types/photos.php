<?php
    $this->widget('site.frontend.widgets.photoView.photoViewWidget', array(
        'selector' => '.masonry-news-list_item:data(id=' . $data->_id . ') .masonry-news-list_img-list a',
        'entity' => 'Album',
        'entity_id' => $data->album->id,
        'entity_url' => $data->album->url,
    ));
?>

<h3 class="masonry-news-list_title">
    <?=CHtml::link($data->album->title, $data->album->url)?>
    <a href="<?=$data->album->url?>" class="icon-photo"></a>
</h3>
<div class="masonry-news-list_content">
    <ul class="masonry-news-list_img-list clearfix">
        <?php foreach ($data->photos as $d): ?>
            <li><a href="javascript:void(0)" data-id="<?=$d->id?>"><?=CHtml::image($d->getPreviewUrl(64, 61, Image::INVERT, true, AlbumPhoto::CROP_SIDE_TOP), $d->title)?></a></li>
        <?php endforeach; ?>
    </ul>
</div>
<div class="comments-all clearfix">
    <?=CHtml::link('Смотреть весь альбом', $data->album->url)?>
</div>