<?php
/**
 * @var $model NotificationLike
 * @var $check bool
 * @author Alex Kireev <alexk984@gmail.com>
 */
?>
<div class="user-notice-list_i">
    <div class="user-notice-list_i-hold">
        <div class="user-notice-list_deed">
            <span class="user-notice_ico user-notice_ico__like"></span>
            <a href="javascript:;" class="user-notice-list_a-big user-notice-list_a-big__like" onclick="$(this).parent().parent().next().toggle()"><?=$model->count ?></a>
        </div>
        <div class="user-notice-list_desc">
            <?= HDate::GetFormattedTime($model->updated)?>
            <br>
            Новые лайки за сутки
        </div>

        <div class="user-notice-list_post">
        </div>
        <div class="user-notice-list_check"></div>
    </div>
    <div class="user-notice-list_like-hold" style="display: none;">
        <?php foreach ($model->articles as $article): ?>
            <div class="user-notice-list_i user-notice-list_i__like">
                <div class="user-notice-list_i-hold">
                    <div class="user-notice-list_date"></div>
                    <div class="user-notice-list_deed">
                        <span class="user-notice_ico user-notice_ico__like-small"></span>
                        <span class="user-notice-list_tx-big color-gray"><?=$article['count'] ?></span>
                    </div>
                    <?php $this->renderPartial('content_preview', array('entity' => $article['entity'], 'entity_id' => $article['entity_id'])); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>