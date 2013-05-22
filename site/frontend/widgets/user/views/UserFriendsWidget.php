<?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascripts/wantToChat.js');
?>

<div class="user-friends clearfix">

    <?php if (empty($friends)): ?>
        <div class="box-title">Друзья <?=CHtml::link('Найти друзей', array('/friends/find'))?></div>

        <?php if (! Yii::app()->user->isGuest && ! WantToChat::hasCooldown(Yii::app()->user->id)): ?>
            <a href="javascript:;" onclick="WantToChat.send(this); return false;"><img src="/images/cap_wannachat.png" /></a>
        <?php endif; ?>
    <?php else: ?>
        <div class="box-title">
            Друзья <?=CHtml::link('Все (' . $user->getFriendsCount() . ')', array('user/friends', 'user_id' => $user->id))?>
            <?php if ($this->isMyProfile): ?>
                <a href="<?=Yii::app()->createUrl('/friends/search/index')?>" class="btn btn-orange-smallest float-r margin-r20"><span><span>Найти друзей</span></span></a>
            <?php endif; ?>
        </div>

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
    <?php endif; ?>

</div>