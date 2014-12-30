<?php
/**
 * @var $this Avatar
 * @var string $tag
 * @var array $options
 */
$avatarUrl = $this->user->getAvatarUrl($this->size);
?>
<?=CHtml::openTag($tag, $options)?>
    <?php if ($this->user->online):?>
        <span class="ico-status ico-status__online"></span>
    <?php endif ?>
    <?php if ($avatarUrl !== false): ?>
        <?=CHtml::image($avatarUrl, $this->user->getFullName(), array('class' => 'ava_img', 'width' => $this->size, 'height' => $this->size)) ?>
    <?php endif; ?>
<?=CHtml::closeTag($tag); ?>