<?php
/*
 * @var $user User
 */
?>

<a href="" class="ava-small"><?php if ($ava = $user->getAva('small')): ?><?=CHtml::image($ava)?><?php endif; ?></a>