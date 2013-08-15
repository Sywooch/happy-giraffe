<?php
/**
 * @var $this UserAvatarWidget
 */
?><a href="<?=$this->user->getUrl() ?>" class="ava <?=($this->user->gender == 0)?'female':'male' ?> small">
    <?php if ($this->user->online):?>
        <span class="icon-status status-online"></span>
    <?php endif ?>
    <?=CHtml::image($this->user->getAvatarUrl(24)) ?>
</a>