<?php
    $class = 'ava';
    if ($this->user->gender !== null) $class .= ' ' . (($this->user->gender) ? 'male' : 'female');
    if ($this->size !== 'ava') $class .= ' ' . $this->size;
?>

<a class="<?=$class?>" href="<?=($this->user->id == Yii::app()->user->id)? Yii::app()->createUrl('profile/photo', array('returnUrl'=>urlencode(Yii::app()->createUrl('user/profile', array('user_id'=>Yii::app()->user->getId()))))):$this->user->url?>">
    <?php echo CHtml::image($this->user->getAva($this->size)); ?>
</a>