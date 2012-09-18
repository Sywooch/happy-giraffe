<?php
    $initiator = User::model()->findByPk($data->initiator_id);
?>

<li class="clearfix">
    <div class="actions">
        <a href="<?=$data->url?>" class="btn-green small" target="_blank">Перейти</a>
        <a href="javascript:void(0)" onclick="Notifications.delete(this, '<?=$data->_id?>')" class="skip">Я знаю</a>
    </div>
    <div class="content">
        <div class="user">
            <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                'user' => $initiator,
                'small' => true,
                'size' => 'small',
            )); ?>
            <span class="icon-status status-<?=($initiator->online) ? 'online' : 'offline'?>"></span>
        </div>
        <div class="in">
            <?=$data->text?>
            <div class="meta">
                <span class="date"><?=HDate::GetFormattedTime($data->created)?></span>
            </div>
        </div>
    </div>
</li>