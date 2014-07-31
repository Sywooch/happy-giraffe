<?php
/**
 * @var $this Avatar
 * @var string $tag
 * @var array $options
 */
?>
<?=CHtml::openTag($tag, $options)?>
    <?php if ($this->user->online):?>
        <span class="ico-status ico-status__online"></span>
    <?php endif ?>
    <?php if ($this->user->avatar_id): ?>
        <?=CHtml::image($this->user->getAvatarUrl(Avatar::SIZE_MICRO), '', array('class' => 'ava_img')) ?>
    <?php endif; ?>
<?=CHtml::closeTag($tag); ?>