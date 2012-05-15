<?php if (! Yii::app()->user->isGuest && ! WantToChat::hasCooldown(Yii::app()->user->id)): ?>
    <a href="" onclick="WantToChat.send(this); return false;">Хочу!</a>
<?php endif; ?>