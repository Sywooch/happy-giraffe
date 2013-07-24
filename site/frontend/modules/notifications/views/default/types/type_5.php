<?php
/**
 * @var $model NotificationLikes
 * @var $check bool
 * @author Alex Kireev <alexk984@gmail.com>
 */
?>
<div class="user-notice-list_i">
    <div class="user-notice-list_i-hold">
        <div class="user-notice-list_deed">
            <span class="user-notice_ico user-notice_ico__like"></span>
            <a href="javascript:;" class="user-notice-list_a-big user-notice-list_a-big__dashed" onclick="$(this).parent().parent().next().toggle()"><?=$model->count ?></a>
        </div>
        <div class="user-notice-list_desc">
            <?= HDate::GetFormattedTime($model->updated)?>
            <br>
            Новые лайки за сутки
        </div>

        <div class="user-notice-list_post">
        </div>
        <?php $this->renderPartial('set_read', array('model' => $model, 'check' => $check)); ?>
    </div>
    <div class="user-notice-list_inner-hold" style="display: none;">
        <?php foreach ($model->articles as $article): ?>
            <?php $content_model = CActiveRecord::model($article['entity'])->findByPk($article['entity_id']); ?>
            <div class="user-notice-list_i">
                <div class="user-notice-list_i-hold">
                    <div class="user-notice-list_deed">
                        <span class="user-notice_ico user-notice_ico__like-small"></span>
                        <span class="user-notice-list_tx-big color-gray"><?=$article['count'] ?></span>
                    </div>
                    <div class="user-notice-list_desc">
                        <?= HDate::GetFormattedTime($model->updated)?> <br> Лайки к <?= Notification::getContentName($content_model) ?>
                    </div>
                    <?php $this->renderPartial('content_preview', array('model' => $content_model)) ?>
                    <div class="user-notice-list_check"></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>