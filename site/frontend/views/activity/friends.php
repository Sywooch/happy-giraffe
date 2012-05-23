<?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascripts/jquery.jcarousel.js');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascripts/find_friends.js');
?>

<div id="find-friend" class="activity-find-friend">

    <div class="title">Найти <span>друзей</span> <a href="javascript:void(0);" onclick="nextFriendsPage(); return false;"><span>Найти<br/>еще</span></a></div>

    <div id="find-friend-wrapper">
        <?php $this->renderPartial('_friends', compact('friends')); ?>
    </div>
</div>