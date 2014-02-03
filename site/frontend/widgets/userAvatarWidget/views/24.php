<?php
/**
 * @var $this Avatar
 */
?><a href="<?=$this->user->getUrl() ?>" class="ava ava__<?=($this->user->gender == 0)?'female':'male' ?> ava__small">
    <?php if ($this->user->online):?>
        <span class="ico-status ico-status__online"></span>
    <?php endif ?>
    <?php if ($this->user->avatar_id): ?>
        <?=CHtml::image($this->user->getAvatarUrl(Avatar::SIZE_MICRO), '', array('class' => 'ava_img')) ?>
    <?php endif; ?>
</a>