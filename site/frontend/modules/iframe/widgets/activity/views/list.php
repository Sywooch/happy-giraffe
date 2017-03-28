<?php

if ($dp->totalItemCount > 0): ?>
    <?php
    $this->widget(LiteListView::class, array(
        'dataProvider' => $dp,
        'itemView' => 'site.frontend.modules.iframe.widgets.activity.views._view',
        'tagName' => 'div',
        'itemsTagName' => false,
        'template' => '{items}<div class="yiipagination yiipagination__center">{pager}</div>',
    ));
    ?>
<?php else: ?>
    <?php if ($this->ownerId == Yii::app()->user->id): ?>
        <div class="heading-sm">Моя активность</div>
        <div class="profile-cap_hold profile-cap_hold__article">
            <div class="profile-cap_tx">У вас пока нет активности на сайте, поделитесь чем-нибудь интересным с пользователями Веселого Жирафа.<br>
                <a style="display: none;" href="<?= Yii::app()->createUrl('blog/default/form', array('type' => CommunityContent::TYPE_POST, 'useAMD' => true)) ?>" class="fancy">Добавить запись</a>
            </div>
        </div>
    <?php else: ?>
        <div class="cap-empty cap-empty__user-profile">
            <div class="verticalalign-m-help"></div>
            <div class="cap-empty_hold">
                <div class="cap-empty_img"></div>
                <div class="cap-empty_t">Пользователь пока не был активен на сайте </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>