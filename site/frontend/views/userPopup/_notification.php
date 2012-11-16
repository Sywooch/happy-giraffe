<?php
    $initiator = User::model()->findByPk($data->initiator_id);
    if ($initiator === null)
        $data->delete();
else{
?>
<li class="clearfix">
    <div class="actions">
        <?php if ($data->url !== null): ?>
            <a href="<?=$data->url?>" class="btn-green small">Перейти</a>
        <?php endif; ?>
        <a href="javascript:void(0)" onclick="Notifications.del(this, '<?=$data->_id?>')" class="skip">Я знаю</a>
    </div>
    <div class="content">
        <?php if ($data->type != UserNotification::CONTEST_WORK_REMOVED): ?>
            <div class="user">
                <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                    'user' => $initiator,
                    'small' => true,
                    'size' => 'small',
                )); ?>
                <span class="icon-status status-<?=($initiator->online) ? 'online' : 'offline'?>"></span>
            </div>
        <?php endif; ?>
        <div class="in">
            <?=$data->text?>
            <div class="meta">
                <span class="date"><?=HDate::GetFormattedTime($data->created)?></span>
            </div>
        </div>
    </div>
</li><?php
}