<?php
    $class = 'ava';
    if ($this->user->gender !== null) $class .= ' ' . (($this->user->gender) ? 'male' : 'female');
    if ($this->size !== 'ava') $class .= ' ' . $this->size;

$show_link_to_profile = true;
if ($this->user->role == 'virtual user' || $this->user->role == 'moderator')
    $show_link_to_profile = false;

$link_to_profile = $this->user->url;
if ($this->size == 'big' && $this->user->id == Yii::app()->user->id)
    $link_to_profile = Yii::app()->createUrl('profile/photo', array('returnUrl'=>urlencode(Yii::app()->createUrl('user/profile', array('user_id'=>$this->user->id)))));

?>
<div class="user-info clearfix">
    <a <?php if (!$show_link_to_profile) echo 'onclick="return false;"';?> class="<?=$class?>"
        href="<?=($show_link_to_profile)?$link_to_profile:'#'?>">
        <?php echo CHtml::image($this->user->getAva($this->size)); ?>
    </a>
    <?php if(!$this->small): ?>
        <div class="details">
            <span class="icon-status status-<?php echo $this->user->online == 1 ? 'online' : 'offline'; ?>"></span>

            <?php if ($show_link_to_profile):?>
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
                <?php if($this->sendButton): ?>
                    <?php echo CHtml::link('<span class="tip">Написать сообщение</span>', $this->user->getDialogUrl(), array('class' => 'new-message')); ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>