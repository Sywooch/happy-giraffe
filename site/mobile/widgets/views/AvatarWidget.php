<?php
/*
 * @var $user User
 */
?>

<a href="<?=Yii::app()->createUrl('/community/user', array('user_id' => $user->id))?>" class="ava-<?=$this->size?>"><?php if ($ava = $user->getAva($this->size)): ?><?=CHtml::image($ava)?><?php endif; ?></a>