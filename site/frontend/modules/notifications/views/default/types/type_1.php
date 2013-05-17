<?php
/**
 * @var $model NotificationReplyComment
 * @var $check bool
 * @author Alex Kireev <alexk984@gmail.com>
 */
?>
<div class="user-notice-list_i-hold">
    <div class="user-notice-list_date"><?= HDate::GetFormattedTime($model->updated) ?></div>
    <div class="user-notice-list_deed">
        <span class="user-notice_ico user-notice_ico__answer"></span>
        <a href="<?=$model->getUrl() ?>" class="user-notice-list_a-big"><?= $model->count ?></a>
        <span class="user-notice-list_deed-desc">новые ответы на ваш комментарий</span>
    </div>
    <?php $this->renderPartial('comment_preview', array('comment_id' => $model->comment_id)); ?>
    <?php $this->renderPartial('set_read', array('model' => $model, 'check' => $check)); ?>
</div>