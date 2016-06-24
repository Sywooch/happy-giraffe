<?php
/**
 * @var \site\frontend\modules\posts\modules\forums\widgets\onlineUsers\OnlineUsersWidget $this
 * @var \User[] $users
 */
?>

<section class="now-online">
    <div class="title text-center">Сейчас онлайн</div>
    <ul class="now-online__list">
        <?php foreach ($users as $user): ?>
        <li class="now-online__item">
            <a href="<?=$user->getUrl()?>" class="now-online__link"><img src="<?=$user->getAvatarUrl(40)?>" alt="" class="now-online__img"></a>
        </li>
        <?php endforeach; ?>
    </ul>
    <div class="text-center">
        <a href="<?=Yii::app()->controller->createUrl('/friends/search/index')?>" class="w-240 btn btn-xl green-btn fontweight-b registration-button" data-bind="follow: {}">Найти друзей</a>
    </div>
</section>
