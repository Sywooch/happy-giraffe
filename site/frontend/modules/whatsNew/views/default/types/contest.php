<li class="masonry-news-list_item" data-block-id="<?=$data->blockId?>">
    <?php
        $this->widget('site.frontend.widgets.photoView.photoViewWidget', array(
            'selector' => '.masonry-news-list_item:data(blockId=' . $data->blockId . ') .masonry-news-list_img-list a',
            'entity' => 'Contest',
            'entity_id' => $data->contest->id,
            'entity_url' => $data->contest->url,
            'query' => array('sort' => 'created'),
            'print_script' => true
        ));
    ?>

    <h3 class="masonry-news-list_title">
        <a href="<?=$data->contest->url?>">Новые участники фотоконкурса</a>
        <a href="<?=$data->contest->url?>" class="icon-photo"></a>
    </h3>
    <div class="clearfix">
        <span class="date"><?=HDate::GetFormattedTime($data->last_updated)?></span>
    </div>
    <?php if ($data->contest->id >= 4): ?>
        <div class="clearfix">
            <img src="/images/broadcast/title-contest-<?=$data->contest->id?>.jpg" alt="" class="title-img"/>
        </div>
    <?php endif; ?>
    <div class="masonry-news-list_content">
        <ul class="masonry-news-list_img-list clearfix">
            <?php foreach ($data->works as $w): ?>
                <li><a href="javascript:void(0)" data-id="<?=$w->photoAttach->photo->id?>"><?=CHtml::image($w->photoAttach->photo->getPreviewUrl(64, 61, Image::INVERT, true, AlbumPhoto::CROP_SIDE_TOP), $w->title)?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="textalign-c clearfix">
        <a href="<?=$data->contest->url?>">Все участники (<?=$data->contest->worksCount?>)</a>
    </div>
</li>
