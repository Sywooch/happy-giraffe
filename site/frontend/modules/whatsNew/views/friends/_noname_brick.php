<li class="masonry-news-list_item<?php if ($data->type == FriendEvent::TYPE_POST_ADDED && $data->content->isFromBlog): ?> blog<?php endif; ?>" data-id="<?=$data->_id?>">
    <div class="masonry-news-list_friend-info clearfix">
        <span class="date"><?=HDate::GetFormattedTime($data->updated)?></span>
        <p><?=$data->label?></p>
    </div>
    <?php Yii::app()->controller->renderPartial($data->view, compact('data')); ?>
</li>