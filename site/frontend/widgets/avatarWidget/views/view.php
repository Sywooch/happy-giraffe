<?php
    $class = 'ava';
    if ($this->user->gender !== null) $class .= ' ' . (($this->user->gender) ? 'male' : 'female');
    if ($this->size !== 'ava') $class .= ' ' . $this->size;
?>

<div class="user-info clearfix">
    <?php if (Yii::app()->user->getId() > 10371):?>
    <a class="<?=$class?>" href="<?=($this->user->id == Yii::app()->user->id && $this->size == 'big')? Yii::app()->createUrl('profile/photo', array('returnUrl'=>urlencode(Yii::app()->createUrl('user/profile', array('user_id'=>Yii::app()->user->getId()))))):$this->user->url?>">
        <?php echo CHtml::image($this->user->getAva($this->size)); ?>
    </a>
    <?php else: ?>
    <a onclick="return false;" class="<?=$class?>" href="<?=($this->user->id == Yii::app()->user->id && $this->size == 'big')? Yii::app()->createUrl('profile/photo', array('returnUrl'=>urlencode(Yii::app()->createUrl('user/profile', array('user_id'=>Yii::app()->user->getId()))))):'#'//$this->user->url?>">
        <?php echo CHtml::image($this->user->getAva($this->size)); ?>
    </a>
    <?php endif ?>
    <?php if(!$this->small): ?>
        <div class="details">
            <span class="icon-status status-<?php echo $this->user->online == 1 ? 'online' : 'offline'; ?>"></span>
            <?php if (Yii::app()->user->getId() > 10371):?>
                <a href="<?=$this->user->url ?>"><?php echo $this->user->fullName ?></a>
            <?php else: ?>
                <?php echo $this->user->fullName ?>
            <?php endif ?>
            <?php if ($this->user->country !== null): ?>
                <div class="location">
                    <div class="flag flag-<?php echo $this->user->country->iso_code; ?>"></div>
                    <?php echo $this->user->country->name; ?>
                </div>
            <?php endif; ?>
            <div class="user-fast-buttons clearfix">
                <?php if($this->friendButton): ?>
                    <?php CController::renderPartial('webroot.themes.happy_giraffe.views.user._friend_button', array(
                        'user' => $this->user,
                    )); ?>
                <?php endif; ?>
                <?php echo CHtml::link('<span class="tip">Написать сообщение</span>', $this->user->getDialogUrl(), array('class' => 'new-message')); ?>
            </div>
        </div>
    <?php endif; ?>
</div>