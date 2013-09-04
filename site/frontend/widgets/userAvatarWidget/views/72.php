<?php
/**
 * @var $this Avatar
 */
?><a href="<?=$this->url ?>" class="ava <?=($this->user->gender == 0)?'female':'male' ?>">
    <?php if ($this->user->online):?>
        <span class="icon-status status-online"></span>
    <?php endif ?>
    <?=CHtml::image($this->user->getAvatarUrl()) ?>
</a>