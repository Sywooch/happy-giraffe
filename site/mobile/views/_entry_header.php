<?php
/*
 * @var $data CommunityContent
 * @var $full boolean
 */
?>

<div class="entry_h clearfix">
    <h1 class="entry_h1"><?=CHtml::link($data->title, $data->url)?></h1>
    <div class="entry_meta">
        <a href="<?=$this->createUrl('comments', array('content_id' => $data->id))?>" class="entry_comments"><i class="ico-comment-small"></i> <?=$data->getUnknownClassCommentsCount()?></a>
        <div class="entry_views"><i class="ico-eye-small"></i> <?=($full) ? $this->getViews() : PageView::model()->viewsByPath($data->url)?></div>
    </div>
    <div class="entry_user clearfix">
        <div class="user-info">
            <a href="" class="ava-small"><?php if ($ava = $data->author->getAva('small')): ?><?=CHtml::image($ava)?><?php endif; ?></a>
            <div class="user-info_details">
                <?=CHtml::link($data->author->fullName, '', array('class' => 'user-info_name textdec-onhover'))?>
                <div class="user-info_time"><?=HDate::GetFormattedTime($data->created, ', ')?></div>
            </div>
        </div>
    </div>
</div>