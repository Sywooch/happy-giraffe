<?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascripts/wantToChat.js');
?>

<div class="user-friends clearfix">

    <?php if (empty($friends)): ?>
        <div class="box-title">Друзья <?=CHtml::link('Найти друзей', '/friends/find')?></div>

        <?php if (! Yii::app()->user->isGuest && ! WantToChat::hasCooldown(Yii::app()->user->id)): ?>
            <a href="javascript:;" onclick="WantToChat.send(this); return false;"><img src="/images/cap_wannachat.png" /></a>
        <?php endif; ?>
    <?php else: ?>
        <div class="box-title">Друзья <?php echo CHtml::link('Все друзья (' . $user->getFriendsCount() . ')', array('user/friends', 'user_id' => $user->id)); ?></div>

        <ul class="clearfix">
            <?php foreach ($friends as $f): ?>
                <li><?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $f, 'small' => true)); ?></li>
            <?php endforeach; ?>
            <?php if (Yii::app()->user->id == $this->user->id):?>
                <?php for($i=count($friends); $i < 6;$i++): ?>
                    <li class="empty"><div class="img"></div></li>
                <?php endfor; ?>
            <?php endif ?>
        </ul>

        <?php if (Yii::app()->user->id == $this->user->id):?>
            <div class="more-friends"><i class="icon-friends-small"></i><?=CHtml::link('Найти ещё друзей', array('/friends/find'))?><?php if (! Yii::app()->user->isGuest && ! WantToChat::hasCooldown(Yii::app()->user->id)): ?> <a href="" class="wannachat" onclick="WantToChat.send(this); return false;">Хочу общаться!</a><?php endif; ?></div>
        <?php endif ?>
    <?php endif; ?>

</div>