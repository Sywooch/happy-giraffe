<div class="clearfix user-info-big">
    <div class="text-status">
        <p><?=Str::truncate($data->content->status->text, 128)?></p>
        <span class="tale"></span>
        <div class="meta nofloat">
            <span class="views"><span class="icon"></span> <span><?=PageView::model()->viewsByPath($data->content->url)?></span></span>
                <span class="comments">
                    <a class="icon" href="<?=$data->content->getUrl(true)?>"></a>
                    <a href="<?=$data->content->getUrl(true)?>"><?=$data->content->commentsCount?></a>
                </span>
        </div>
    </div>
</div>
<div class="textalign-c clearfix">
    <a href="<?=$data->content->getUrl(true)?>">Добавить комментарий</a>
</div>