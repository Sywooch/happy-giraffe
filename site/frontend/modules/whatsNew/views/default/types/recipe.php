<li class="masonry-news-list_item cook" data-block-id="<?=$data->blockId?>">
    <?php
    $this->widget('site.frontend.widgets.photoView.photoViewWidget', array(
        'selector' => '.masonry-news-list_item:data(blockId=' . $data->blockId . ') .title-img a',
        'entity' => 'CookRecipe',
        'entity_id' => $data->recipe->id,
        'entity_url' => $data->recipe->url,
        'print_script' => true
    ));
    ?>

    <h3 class="masonry-news-list_title">
        <?=CHtml::link($data->recipe->title, $data->recipe->url)?>
    </h3>
    <div class="clearfix">
        <a href="" class="sub-category"><span class="icon-cook"></span>Кулинарный рецепт</a>
    </div>
    <?php if ($data->recipe->mainPhoto !== null): ?>
    <div class="clearfix">
        <div class="title-img">
            <?=CHtml::link(CHtml::image($data->recipe->mainPhoto->getPreviewUrl(198, null, Image::WIDTH), $data->recipe->title).'<span class="btn-view">Посмотреть</span>', 'javascript:void(0)', array('data-id' => $data->recipe->mainPhoto->id))?>
        </div>
    </div>
    <?php endif; ?>
    <div class="masonry-news-list_meta-info clearfix">

        <div class="meta">
            <div class="views"><span class="icon" href="#"></span> <span><?=PageView::model()->viewsByPath($data->recipe->url)?></span></div>
            <?php if ($data->recipe->commentsCount == 0): ?>
            <div class="comments empty">
                <a class="icon" href="<?=$data->recipe->getUrl(true)?>"></a>
            </div>
            <?php else: ?>
            <div class="comments">
                <a class="icon" href="<?=$data->recipe->getUrl(true)?>"></a>
                <a href="<?=$data->recipe->getUrl(true)?>"><?=$data->recipe->commentsCount?></a>
            </div>
            <?php endif; ?>
        </div>

        <div class="user-info">
            <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
            'user' => $data->recipe->author,
            'small' => true,
            'size' => 'small',
        )); ?>
            <div class="details">
                <a class="username" href="<?=$data->recipe->author->url?>"><?=$data->recipe->author->first_name?></a>
                <span class="date"><?=HDate::GetFormattedTime($data->last_updated)?></span>
            </div>
        </div>
    </div>
    <div class="masonry-news-list_content">
        <p><?=Str::truncate(strip_tags($data->recipe->text), 128)?> <a href="<?=$data->recipe->url?>" class="all">Читать</a></p>
    </div>
</li>