<div class="friends-empty">
    <h3 class="title"><?=$title?></h3>
    <div class="find">
        <div class="button">
            <a class="btn-green" href="<?=$this->createUrl('/friends/find')?>">Найти<br>друзей</a>
        </div>
        <p>Вы можете найти друзей по интересам, по месту жительства, по похожему семейному положению, отправить им приглашение дружбы или просто написать им.<br><br>Желаем вам найти много друзей! Удачи!</p>

    </div>
    <?php if (! Yii::app()->user->isGuest && ! WantToChat::hasCooldown(Yii::app()->user->id)): ?>
    <div class="friends-total">
        Чтобы вас заметили на сайте, нажмите
        <a class="wannachat" href="javascript:void(0)" onclick="WantToChat.send(this);">Хочу общаться!</a>
    </div>
    <?php endif; ?>
</div>