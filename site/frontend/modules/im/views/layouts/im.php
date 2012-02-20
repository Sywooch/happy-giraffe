<?php $this->beginContent('//layouts/club'); ?>
<?php
Yii::app()->clientScript
    ->registerScriptFile('/javascripts/dklab_realplexor.js')
    ->registerScript('Realplexor-reg', '
        var user_cache = "' . MessageCache::GetCurrentUserCache() . '";
        var last_dialog = "' . ActiveDialogs::model()->getLastDialogId() . '";
        var realplexor = new Dklab_Realplexor(
            "http://' . Yii::app()->comet->host . '",
            "' . Yii::app()->comet->namespace . '"
        );

        realplexor.subscribe(user_cache, function (result, id) {
            console.log(result);
            if (result.type == ' . MessageLog::TYPE_NEW_MESSAGE . ') {
                if(window.ShowNewMessage)
                    ShowNewMessage(result);
            } else if (result.type == ' . MessageLog::TYPE_READ . ') {
                if(window.ShowAsRead)
                    ShowAsRead(result);
            } else if (result.type == ' . MessageLog::TYPE_STATUS_CHANGE . ') {
                if(window.StatusChanged)
                    StatusChanged(result);
            } else if (result.type == ' . MessageLog::TYPE_USER_WRITE . ') {
                if(window.ShowUserTyping)
                    ShowUserTyping(result);
            }
        });
        realplexor.execute();
')
    ->registerScript('im_script', '

    ');
?>
<div class="main">

    <div class="main-right">

        <div id="dialogs">

            <div class="header clearfix">
                <big>Мои сообщения</big>
                <ul>
                    <li<?php if (Yii::app()->controller->action->id == 'index') echo ' class="active"'?>><a href="<?php
                    echo $this->createUrl('/im/default/index', array()) ?>"><span>Все диалоги</span></a></li>

                    <li<?php if (Yii::app()->controller->action->id == 'new') echo ' class="active"'?>>
                        <a href="<?php echo $this->createUrl('/im/default/new', array()) ?>"><span>Новые</span>
                            <?php $count = Im::getUnreadMessagesCount(Yii::app()->user->getId()); ?>
                            <div
                                class="count"<?php if ($count == 0) echo ' style="display:none;"' ?>><?php echo $count ?></div>
                        </a></li>

                    <li<?php if (Yii::app()->controller->action->id == 'online') echo ' class="active"'?>>
                        <a href="<?php echo $this->createUrl('/im/default/online', array()) ?>"><span>Кто в онлайне</span></a>
                    </li>

                    <?php $d = ActiveDialogs::model()->getDialogIds();
                    if (!empty($d)):?>
                        <li class="<?php if (Yii::app()->controller->action->id == 'dialog') echo ' active'?>">
                            <a href="<?php echo $this->createUrl('/im/default/dialog',
                                array('id' => ActiveDialogs::model()->getLastDialogId())) ?>">Открытые диалоги</a></li>
                        <?php endif ?>
                </ul>
            </div>
            <?php echo $content ?>
        </div>
    </div>
</div>

<div class="side-right">

    <?php echo User::GetCurrentUserWithBabies()->getUserPriority() ?>

</div>
<?php $this->endContent(); ?>