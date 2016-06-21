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
            <a href="<?=$user->profileUrl?>" class="now-online__link"><img src="/images/icons/ava.jpg" alt="" class="now-online__img"></a>
        </li>
        <?php endforeach; ?>
    </ul>
</section>
