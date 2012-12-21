<div class="masonry-news-list_comment top">
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
    <div class="masonry-news-list_comment-text">
        <a href="<?=$comment->url?>"><?=Str::getDescription($comment->text, 250)?></a>
    </div>
</div>