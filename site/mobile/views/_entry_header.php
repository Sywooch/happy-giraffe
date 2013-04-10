<?php
/*
 * @var $data CommunityContent
 * @var $full boolean
 */
if (get_class($data) == 'CommunityContent' || get_class($data) == 'BlogContent') {
    $entity = $data->isFromBlog ? 'BlogContent' : 'CommunityContent';
} elseif (get_parent_class($data) == 'CookRecipe') {
    $entity = 'CookRecipe';
} else {
    $entity = get_class($data);
}
?>

<div class="entry_h clearfix">
    <h1 class="entry_h1"><?=CHtml::link($data->title, $data->url)?></h1>
    <div class="entry_meta">
        <?php if ($data->getUnknownClassCommentsCount() > 0): ?>
            <a href="<?=$this->createUrl('/site/comments', array('entity' => $entity, 'entity_id' => $data->id))?>" class="entry_comments"><i class="ico-comment-small"></i> <?=$data->getUnknownClassCommentsCount()?></a>
        <?php endif; ?>
        <div class="entry_views"><i class="ico-eye-small"></i> <?=($full) ? $this->getViews() : PageView::model()->viewsByPath($data->url)?></div>
    </div>
    <div class="entry_user clearfix">
        <div class="user-info">
            <?php $this->widget('AvatarWidget', array('user' => $data->author)); ?>
            <div class="user-info_details">
                <?=CHtml::link($data->author->fullName, array('user/index', 'user_id' => $data->author_id, 'show' => 'all'), array('class' => 'user-info_name textdec-onhover'))?>
                <div class="user-info_time"><?=HDate::GetFormattedTime($data->created, ', ')?></div>
            </div>
        </div>
    </div>
</div>