<?php
/**
 * @var $data BlogContent
 * @var $full bool
 */
$data = $this->last_status;
$status = $data->getStatus();
$text = strip_tags($status->text);
?>
<div class="b-user-status">
    <div class=" clearfix">
        <div class="meta-gray">
            <a href="<?= $data->getUrl(true) ?>" class="meta-gray_comment">
                <span class="ico-comment ico-comment__gray"></span>
                <span class="meta-gray_tx"><?=$data->commentsCount ?></span>
            </a>
            <div class="meta-gray_view">
                <span class="ico-view ico-view__gray"></span>
                <span class="meta-gray_tx"><?=PageView::model()->viewsByPath($data->getUrl())?></span>
            </div>
        </div>
        <div class="float-l">
            <span class="font-smallest color-gray"><?=HDate::GetFormattedTime($data->created)?></span>
        </div>
    </div>

    <div class="b-user-status_hold clearfix">
        <a href="<?=$data->getUrl() ?>" class="b-user-status_hold-a"><?=$text ?></a>

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
