<li class="masonry-news-list_item" data-block-id="<?=$data->blockId?>">
    <?php
        $this->widget('site.frontend.widgets.photoView.photoViewWidget', array(
            'selector' => '.masonry-news-list_item:data(blockId=' . $data->blockId . ') .masonry-news-list_img-list a',
            'entity' => 'CookDecorationCategory',
            'entity_id' => null,
            'entity_url' => $this->createUrl('/cook/decor/index'),
            'place'=>'gallery'
        ));
    ?>

    <h3 class="masonry-news-list_title">
        <a href="<?=$this->createUrl('/cook/decor/index')?>">Новые фото Оформление блюд</a>
        <a href="<?=$this->createUrl('/cook/decor/index')?>" class="icon-photo"></a>
    </h3>
    <div class="clearfix">
        <span class="date"><?=HDate::GetFormattedTime($data->last_updated)?></span>
    </div>
    <div class="clearfix">
        <a href="<?=$this->createUrl('/cook/decor/index')?>"><img src="/images/broadcast/title-dishes.jpg" alt="" class="title-img"/></a>
    </div>
    <div class="masonry-news-list_content">
        <ul class="masonry-news-list_img-list clearfix">
            <?php foreach ($data->decorations as $d): ?>
                <li><a href="javascript:void(0)" data-id="<?=$d->photo->id?>"><?=CHtml::image($d->photo->getPreviewUrl(64, 61, Image::INVERT, true, AlbumPhoto::CROP_SIDE_TOP), $d->title)?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="textalign-c clearfix">
        <a href="<?=$this->createUrl('/cook/decor/index')?>">Смотреть все</a>
    </div>
</li>
<script type="text/javascript">$(function() {});</script>