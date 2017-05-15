<div class="notice-header clearfix notice-header--dialog">
    <div class="notice-header__item notice-header__item--left">
        <div class="notice-header__title"><span class="notice-header-signal__icon"></span> Сигналы</div>
    </div>
    <div class="notice-header__item notice-header__item--right"><a href="javascript:history.back();" class="notice-header__ico-close i-close i-close--sm"></a></div>
</div>
<div class="b-main_cont b-main_cont__wide b-main_notification">
    <div class="notification-title notification-title__unread">Новые <?=$unreadCount?></div>
    <div class="notification-list">
        <?php
            foreach ($unreadList as $item){
                foreach ($item->unreadEntities as $entities) {
                    $this->renderPartial('_item', ['model' => $item, 'data' => $entities]);
                }
            }
        ?>
    </div>
    <div class="notification-title notification-title__read">Прочитанные <?=$readCount?></div>
    <div class="notification-list">
        <?php
        foreach ($readList as $item){
            foreach ($item->readEntities as $entities) {
                $this->renderPartial('_item', ['model' => $item, 'data' => $entities]);
            }
        }
        ?>
    </div>
</div>