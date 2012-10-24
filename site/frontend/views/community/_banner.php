<div class="recent-banner-article <?=$data->class?>">
    <a href="<?=$data->content->url?>">
        <span class="img">
            <?=CHtml::image($data->photo->getPreviewUrl(240, null, Image::WIDTH))?>
        </span>
        <span class="title-box">
            <span class="title"><?=$data->title?></span>
            <span class="statistic clearfix">
                <i class="icon-eye"></i> <?=PageView::model()->viewsByPath($data->content->url)?>
                <i class="icon-comment"></i> <?=$data->content->commentsCount?>
            </span>
        </span>
    </a>
</div>