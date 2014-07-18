<?php
/**
 * @var $this Avatar
 */
$tag = $this->user->deleted == 1 ? 'span' : 'a';
$class = 'ava ava__' . (($this->user->gender == 0) ? 'female' : 'male');
$options = array(
    'class' => $class,
);
if ($this->user->deleted == 0) {
    $options['href'] = $this->user->getUrl();
}
?>
<?=CHtml::openTag($tag, $options)?>
    <?php if ($this->user->online):?>
        <span class="ico-status ico-status__online"></span>
    <?php endif ?>
    <?=CHtml::image($this->user->getAvatarUrl(), '', array('class' => 'ava_img')) ?>
<?=CHtml::closeTag($tag); ?>