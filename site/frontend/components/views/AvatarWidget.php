<?php
    $class = 'ava';
    if ($user->gender !== null) $class .= ' ' . (($user->gender) ? 'male' : 'female');
    if ($this->size !== 'ava') $class .= ' ' . $this->size;
?>

<div class="<?=$class?>">
    <?php echo CHtml::image($user->getAva($this->size)); ?>
</div>