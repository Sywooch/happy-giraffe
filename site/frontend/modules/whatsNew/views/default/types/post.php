<li class="masonry-news-list_item<?php if ($data->post->isFromBlog): ?> blog<?php endif; ?>" data-block-id="<?=$data->blockId?>">
    <h3 class="masonry-news-list_title">
        <?=CHtml::link($data->post->title, $data->post->url)?>
        <?php if ($data->post->type->slug == 'video'): ?>
            <a href="<?=$data->post->url?>" class="icon-video"></a>
        <?php endif; ?>

        <?php if ($data->post->gallery !== null): ?>
            <a href="<?=$data->post->url?>" class="icon-photo"></a>
        <?php endif; ?>
    </h3>
    <?php if (! $data->post->isFromBlog): ?>
        <div class="clearfix">
            <a href="<?=$data->post->rubric->community->url?>" class="club-category <?=$data->post->rubric->community->css_class?>"><?=$data->post->rubric->community->shortTitle?></a>
        </div>
    <?php else: ?>
        <div class="clearfix">
            <span class="sub-category"><span class="icon-blog"></span>Личный блог</span>
        </div>
    <?php endif; ?>
    <div class="masonry-news-list_meta-info clearfix">

        <div class="meta">
            <div class="views"><span class="icon" href="#"></span> <span><?=PageView::model()->viewsByPath($data->post->url)?></span></div>
            <?php if ($data->post->commentsCount == 0): ?>
                <div class="comments empty">
                    <a class="icon" href="<?=$data->post->getUrl(true)?>"></a>
                </div>
            <?php else: ?>
                <div class="comments">
                    <a class="icon" href="<?=$data->post->getUrl(true)?>"></a>
                    <a href="<?=$data->post->getUrl(true)?>"><?=$data->post->commentsCount?></a>
                </div>
            <?php endif; ?>
        </div>

        <div class="user-info">
            <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                'user' => $data->post->contentAuthor,
                'small' => true,
                'size' => 'small',
            )); ?>
            <div class="details">
                <a class="username" href="<?=$data->post->contentAuthor->url?>"><?=$data->post->contentAuthor->first_name?></a>
                <span class="date"><?=HDate::GetFormattedTime($data->last_updated)?></span>
            </div>
        </div>
    </div>
    <div class="masonry-news-list_content">
        <?php if ($data->post->gallery !== null): ?>
            <?php
                $this->widget('site.frontend.widgets.photoView.photoViewWidget', array(
                    'selector' => '.masonry-news-list_item:data(blockId=' . $data->blockId . ') .masonry-news-list_img-list a',
                    'entity' => 'CommunityContentGallery',
                    'entity_id' => $data->post->gallery->id,
                    'entity_url' => $data->post->url,
                ));
            ?>

            <ul class="masonry-news-list_img-list clearfix">
                <?php for ($i = 0; isset($data->post->gallery->items[$i]) && $i < 9; $i++): ?>
                    <li><a href="javascript:void(0)" data-id="<?=$d->photo->id?>"><?=CHtml::image($d->photo->getPreviewUrl(64, 61, Image::INVERT, true, AlbumPhoto::CROP_SIDE_TOP), $d->description)?></a></li>
                <?php endfor; ?>
            </ul>
        <?php elseif ($data->post->type_id == 2): ?>
            <?=$data->post->video->getResizedEmbed(198)?>
        <?php else: ?>
            <?php if ($data->post->getContentImage() !== false): ?>
                <?=CHtml::link(CHtml::image($data->post->getContentImage(), $data->post->title), $data->post->url)?>
            <?php endif; ?>
            <p><?=$data->post->getContentText(128)?> <a href="<?=$data->post->url?>" class="all">Читать</a></p>
        <?php endif; ?>
    </div>
    <?php if (($comment = $data->comment) !== null): ?>
        <div class="masonry-news-list_comment">
            <div class="masonry-news-list_comment-text">
                <?=Str::truncate(strip_tags($comment->text), 512)?>
            </div>
            <div class="masonry-news-list_meta-info clearfix">
                <div class="user-info">
                    <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                        'user' => $comment->author,
                        'small' => true,
                        'size' => 'small',
                    )); ?>
                    <div class="details">
                        <a class="username" href="<?=$comment->author->url?>"><?=$comment->author->first_name?></a>
                        <span class="date"><?=HDate::GetFormattedTime($comment->created)?></span>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($data->post->commentsCount > 1): ?>
            <div class="comments-all">
                <a href="<?=$data->post->getUrl(true)?>">еще <?=($data->post->commentsCount - 1)?></a>
                <a href="<?=$data->post->getUrl(true)?>" class="icon-comment"></a>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</li>