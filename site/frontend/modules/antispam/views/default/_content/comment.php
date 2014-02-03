<?php
/**
 * @var HController $this
 * @var Comment $data
 */

$commentEntity = $data->getCommentEntity();
?>

<section class="comments-gray comments-gray__wide clearfix">
    <div class="comments-gray_i">
        <div class="comments-gray_ava">
            <?php $this->widget('site.frontend.widgets.userAvatarWidget.Avatar', array('user' => $data->author, 'size' => 40)); ?>
        </div>
        <div class="comments-gray_r">
            <div class="comments-gray_date"><?=HDate::GetFormattedTime($data->created)?></div>
        </div>
        <div class="comments-gray_frame">
            <div class="comments-gray_header clearfix"><a href="<?=$data->author->getUrl()?>" class="comments-gray_author"><?=$data->author->getFullName()?></a></div>
            <div class="comments-gray_cont wysiwyg-content">
                <?=$data->purified->text?>
            </div>
            <?php if (isset($commentEntity->title) && isset($commentEntity->url)): ?>
            <div class="font-s">
                к <?=CHtml::link($commentEntity->title, $commentEntity->url)?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>