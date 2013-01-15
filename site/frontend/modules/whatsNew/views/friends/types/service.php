<h3 class="masonry-news-list_title textalign-c">
    <?=CHtml::link($data->service->title, $data->service->url)?>
</h3>
<div class="masonry-news-list_content">
    <?=CHtml::link(HHtml::lazyImage($data->service->photo->getPreviewUrl(104, null, Image::WIDTH)), $data->service->url)?>
</div>
<div class="comments-all clearfix">
    <?=CHtml::link('Попробовать сервис!', $data->service->url)?>
</div>