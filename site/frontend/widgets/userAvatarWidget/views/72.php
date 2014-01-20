<?php
/**
 * @var $this Avatar
 */
?><a href="<?=$this->user->getUrl() ?>" class="ava ava__<?=($this->user->gender == 0)?'female':'male' ?>">
    <?php if ($this->user->online):?>
        <span class="ico-status ico-status__online"></span>
    <?php endif ?>
    <?=CHtml::image($this->user->getAvatarUrl(), '', array('class' => 'ava_img')) ?>
</a>