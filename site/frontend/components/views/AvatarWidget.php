<?php
    $class = 'ava';
    if ($this->user->gender !== null) $class .= ' ' . (($this->user->gender) ? 'male' : 'female');
    if ($this->size !== 'ava') $class .= ' ' . $this->size;
?>

<a class="<?=$class?>" href="<?=$this->user->profileUrl?>">
    <?php echo CHtml::image($this->user->getAva($this->size)); ?>
</a>