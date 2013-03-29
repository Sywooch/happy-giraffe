<?php
/**
 * @var $user User
 * @author Alex Kireev <alexk984@gmail.com>
 */

?><div class="user-info clearfix">
    <a href="http://www.happy-giraffe.ru/user/<?=$user->id ?>/" class="ava small" target="_blank"><?=CHtml::image($user->getAva('small')) ?></a>
    <div class="user-info_details">
        <a href="http://www.happy-giraffe.ru/user/<?=$user->id ?>/" class="user-info_username" target="_blank"><?=$user->fullName ?></a>
    </div>
</div>