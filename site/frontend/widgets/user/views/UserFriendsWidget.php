<?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascripts/wantToChat.js');
?>

<div class="user-friends clearfix">

    <?php if (empty($friends)): ?>
        <div class="box-title">Друзья <?=CHtml::link('Найти друзей', '/activity/friends')?></div>

        <?php if (! Yii::app()->user->isGuest && ! WantToChat::hasCooldown(Yii::app()->user->id)): ?>
            <a href="" onclick="WantToChat.send(this); return false;"><img src="/images/cap_wannachat.png" /></a>
        <?php endif; ?>
    <?php else: ?>
        <div class="box-title">Друзья <?php echo CHtml::link('Все друзья (' . $user->getFriendsCount() . ')', array('user/friends', 'user_id' => $user->id)); ?></div>

        <ul class="clearfix">
            <?php foreach ($friends as $f): ?>
                <li><?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $f, 'small' => true)); ?></li>
            <?php endforeach; ?>
            <?php for($i=count($friends); $i < 6;$i++): ?>
                <li><div class="img"></div></li>
            <?php endfor; ?>
        </ul>

        <div class="more-friends"><?=CHtml::link('Найти ещё друзей', array('/activity/friends'))?><?php if (! Yii::app()->user->isGuest && ! WantToChat::hasCooldown(Yii::app()->user->id)): ?> <a href="" class="wannachat" onclick="WantToChat.send(this); return false;">Хочу общаться!</a><?php endif; ?></div>
    <?php endif; ?>

</div>