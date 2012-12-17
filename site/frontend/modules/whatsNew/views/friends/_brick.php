<?php if ($listView && $page == 0): ?>
    <?php $this->renderPartial('/_update_message'); ?>
<?php endif; ?>

<li class="masonry-news-list_item<?php if ($data->type == FriendEvent::TYPE_POST_ADDED && $data->content->isFromBlog): ?> blog<?php endif; ?>" data-id="<?=$data->_id?>">
    <div class="masonry-news-list_friend-info clearfix">
        <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
            'user' => $data->user,
            'small' => true,
            'size' => 'small',
        )); ?>
        <div class="details">
            <a class="username" href="<?=$data->user->url?>"><?=$data->user->first_name?></a>
            <span class="date"><?=HDate::GetFormattedTime($data->updated)?></span>
            <p><?=$data->label?></p>
        </div>
    </div>
    <?php Yii::app()->controller->renderPartial($data->view, compact('data')); ?>
</li>