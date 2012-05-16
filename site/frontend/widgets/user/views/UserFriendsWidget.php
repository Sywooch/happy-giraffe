<?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascripts/wantToChat.js');
?>

<div class="user-friends clearfix">

    <div class="box-title">Друзья <?php echo CHtml::link('Все друзья (' . $user->getFriendsCount() . ')', array('user/friends', 'user_id' => $user->id)); ?></div>

    <ul>
        <?php foreach ($friends as $f): ?>
            <li><?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $f, 'small' => true)); ?></li>
        <?php endforeach; ?>
    </ul>

    <div class="more-friends"><?=CHtml::link('Найти ещё друзей', '/activity/friends')?><?php if (! Yii::app()->user->isGuest && ! WantToChat::hasCooldown(Yii::app()->user->id)): ?> <a href="" class="wannachat" onclick="WantToChat.send(this); return false;">Хочу общаться!</a><?php endif; ?></div>

</div>