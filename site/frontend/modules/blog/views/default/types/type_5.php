<?php
/**
 * @var $this DefaultController
 * @var $data BlogContent
 * @var $full bool
 * @var bool $showTitle
 */

$status = $data->getStatus();
$text = strip_tags($status->text);
?>
<div class="b-article_in clearfix">
    <div class="b-article_user-status clearfix">
        <?php if (!$full):?>
            <?php if ($show_new && ViewedPost::getInstance()->isViewed($data->id)): ?>
                <div class="b-article_t-new">новое</div>
            <?php endif ?>
            <a href="<?=$data->getUrl() ?>" class="b-article_user-status-a"><?=$text ?></a>
        <?php else: ?>
            <span class="b-article_user-status-a"><?=$text?></span>
        <?php endif ?>

        <?php if ($status->mood): ?>
        <div class="textalign-r clearfix">
            <div class="b-user-mood">
                <div class="b-user-mood_hold">
                    <div class="b-user-mood_tx">Мое настроение -</div>
                </div>
                <div class="b-user-mood_img">
                    <img src="/images/widget/mood/<?=$status->mood_id?>.png">
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
