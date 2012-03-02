<?php $this->beginContent('//layouts/club'); ?>
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