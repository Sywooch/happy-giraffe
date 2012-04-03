<?php
    $class = 'ava';
    if ($this->user->gender !== null) $class .= ' ' . (($this->user->gender) ? 'male' : 'female');
    if ($this->size !== 'ava') $class .= ' ' . $this->size;
    if($this->filled) $class .= ' filled';

$link_to_profile = $this->user->url;
if ($this->size == 'big' && $this->user->id == Yii::app()->user->id)
    $link_to_profile = Yii::app()->createUrl('profile/photo', array('returnUrl'=>urlencode(Yii::app()->createUrl('user/profile', array('user_id'=>$this->user->id)))));

?>
<?php if(!$this->small): ?>
    <div class="user-info clearfix">
<?php endif; ?>
    <a class="username <?=$class?>"
        href="<?=$link_to_profile?>">
        <?php if($this->user->getAva($this->size)): ?>
            <?php echo CHtml::image($this->user->getAva($this->size)); ?>
        <?php endif; ?>
    </a>
    <?php if(!$this->small): ?>
        <div class="details">
            <span class="icon-status status-<?php echo $this->user->online == 1 ? 'online' : 'offline'; ?>"></span>
            <a href="<?=$this->user->url ?>"><?php echo $this->user->fullName ?></a>
            <?php if ($this->user->getUserAddress()->country !== null): ?>
                <div class="location">
                    <div class="flag flag-<?php echo $this->user->getUserAddress()->country->iso_code; ?>"></div>
                    <?php echo $this->user->getUserAddress()->cityName; ?>
                </div>
            <?php endif; ?>
            <div class="user-fast-buttons clearfix">
                <?php if($this->friendButton && $this->user->id != Yii::app()->user->id): ?>
                    <?php $this->render('webroot.themes.happy_giraffe.views.user._friend_button', array(
                        'user' => $this->user,
                    )); ?>
                <?php endif; ?>
                <?php if($this->sendButton && $this->user->id != Yii::app()->user->id): ?>
                    <?php echo CHtml::link('<span class="tip">Написать сообщение</span>', $this->user->getDialogUrl(), array('class' => 'new-message')); ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
<?php if(!$this->small): ?>
    </div>
<?php endif; ?>