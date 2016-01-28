<?php
/**
 * @var int $guestsCount
 * @var int $usersCount
 * @var \site\frontend\components\api\models\User[] $users
 */
?>

<div class="who-online">
    <div class="widget-top">
        <div class="heading-wd">Сейчас в сети</div>
        <div class="who-online_hint"><span><?=$usersCount?> </span> пользователей</div>
        <div class="who-online_hint"><span><?=$guestsCount?> </span> гостей</div>
    </div>
    <div class="clearfix"></div>
    <ul class="who-online_ul">
        <?php foreach ($users as $user): ?>
        <li class="who-online_li clearfix">
            <a href="<?=$user->profileUrl?>" class="ava ava__small">
                <img alt="" src="<?=$user->avatarUrl?>" class="ava_img">
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
    <div class="clearfix"></div>
</div>

<?php if (false): ?>
<p>Гостей: <?=$guestsCount?></p>
<p>Пользователей: <?=$usersCount?></p>
<ul>
    <?php foreach ($users as $user): ?>
        <li><img src="<?=$user->avatarUrl?>"></li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>