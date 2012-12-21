<li class="masonry-news-list_item<?php if ($data->post->isFromBlog): ?> blog<?php endif; ?>" data-block-id="<?=$data->blockId?>">

    <?php if (($comment = $data->comment) !== null)
        $this->renderPartial('application.modules.whatsNew.views._comment', array('comment' => $comment)); ?>


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

        <?php $this->renderPartial('application.modules.whatsNew.views._meta', array('model' => $data->post)); ?>

        <div class="user-info">
            <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                'user' => $data->post->contentAuthor,
                'small' => true,
                'size' => 'small',
            )); ?>
            <div class="details">
                <a class="username" href="<?=$data->post->contentAuthor->url?>"><?=$data->post->contentAuthor->first_name?></a>
                <span class="date"><?=HDate::GetFormattedTime($data->post->created)?></span>
            </div>
        </div>
    </div>
    <div class="masonry-news-list_content">
        <?php $this->renderPartial('application.modules.whatsNew.views._post_content', array('post' => $data->post, 'blockId' => $data->blockId)); ?>
    </div>
</li>