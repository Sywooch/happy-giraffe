<?php
/**
 * @var $model NotificationDiscussContinue
 * @var $check bool
 * @author Alex Kireev <alexk984@gmail.com>
 */
?>
<div class="user-notice-list_i-hold">
    <div class="user-notice-list_date"><?= HDate::GetFormattedTime($model->updated) ?></div>
    <div class="user-notice-list_deed">
        <span class="user-notice_ico user-notice_ico__discuss"></span>
        <a href="<?=$model->getUrl() ?>" class="user-notice-list_a-big"><?= $model->count ?></a>
        <span class="user-notice-list_deed-desc">продолжение обсуждения</span>
    </div>
    <?php $this->renderPartial('content_preview', array('entity' => $model->entity, 'entity_id' => $model->entity_id)); ?>
    <?php $this->renderPartial('set_read', array('model' => $model, 'check' => $check)); ?>
</div>