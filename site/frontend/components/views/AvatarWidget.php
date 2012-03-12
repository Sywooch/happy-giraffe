<?php
    $class = 'ava';
    if ($this->user->gender !== null) $class .= ' ' . (($this->user->gender) ? 'male' : 'female');
    if ($this->size !== 'ava') $class .= ' ' . $this->size;
?>

<div class="<?=$class?>">
    <?php echo CHtml::link(CHtml::image($this->user->getAva($this->size)), $this->user->profileUrl); ?>
</div>