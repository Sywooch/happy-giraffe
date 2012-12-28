<?php if ($post->gallery !== null): ?>
    <?php
        $this->widget('site.frontend.widgets.photoView.photoViewWidget', array(
            'selector' => '.masonry-news-list_item:data(blockId=' . $blockId . ') .masonry-news-list_img-list a',
            'entity' => 'CommunityContentGallery',
            'entity_id' => $post->gallery->id,
            'entity_url' => $post->url,
            'print_script' => true
        ));
    ?>
    
    <ul class="masonry-news-list_img-list clearfix">
        <?php foreach ($post->gallery->items as $i => $d): ?>
        <li><a href="javascript:void(0)" data-id="<?=$d->photo->id?>"><?=CHtml::image($d->photo->getPreviewUrl(64, 61, Image::INVERT, true, AlbumPhoto::CROP_SIDE_TOP), $d->description)?></a></li>
        <?php
        if ($i >= 8)
            break;
        ?>
        <?php endforeach; ?>
    </ul>
<?php elseif ($post->type_id == 2): ?>
    <?=$post->video->getResizedEmbed(198)?>
<?php else: ?>
    <?php if ($post->getContentImage() !== false): ?>
        <?=CHtml::link(CHtml::image($post->getContentImage(198), $post->title), $post->url)?>
    <?php endif; ?>
    <p><?=$post->getContentText(128)?> <a href="<?=$post->url?>" class="all">Читать</a></p>
<?php endif; ?>