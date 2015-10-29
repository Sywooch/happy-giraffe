<?php
/**
 * @var int $guestsCount
 * @var int $usersCount
 * @var \site\frontend\components\api\models\User[] $users
 */
?>

<p>Гостей: <?=$guestsCount?></p>
<p>Пользователей: <?=$usersCount?></p>
<ul>
    <?php foreach ($users as $user): ?>
        <li><img src="<?=$user->avatarUrl?>"></li>
    <?php endforeach; ?>
</ul>