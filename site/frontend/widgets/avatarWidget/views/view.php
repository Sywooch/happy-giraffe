<?php
$class = 'ava';
if ($this->user->gender !== null) $class .= ' ' . (($this->user->gender) ? 'male' : 'female');
if ($this->size !== 'ava') $class .= ' ' . $this->size;
if ($this->filled) $class .= ' filled';

if ($this->user->blocked || $this->user->deleted)
    $link_to_profile = 'javascript:;';
else {
    $link_to_profile = $this->user->url;
    if ($this->size == 'big' && $this->user->id == Yii::app()->user->id)
        $link_to_profile = Yii::app()->createUrl('profile/photo', array('returnUrl' => urlencode(Yii::app()->createUrl('user/profile', array('user_id' => $this->user->id)))));
}
?>
<?php if (!$this->small): ?>
    <div class="user-info clearfix">
<?php endif; ?>
    <a class="<?=$class?>"
       href="<?=$link_to_profile?>">
        <?php if ($this->user->getAva($this->size)): ?>
        <?php echo CHtml::image($this->user->getAva($this->size)); ?>
        <?php endif; ?>
    </a>
<?php if (!$this->small): ?>
    <?php if ($this->user->id != User::HAPPY_GIRAFFE): ?>
        <div class="details">
            <span class="icon-status status-<?php echo $this->user->online == 1 ? 'online' : 'offline'; ?>"></span>
            <a class="username" href="<?=$link_to_profile ?>"><?php echo CHtml::encode($this->user->fullName); ?></a>
            <?php if ($this->user->getUserAddress()->country !== null && $this->location): ?>
            <div class="location">
                <div class="flag flag-<?php echo $this->user->getUserAddress()->country->iso_code; ?>"></div>
                <?php echo CHtml::encode($this->user->getUserAddress()->cityName); ?>
            </div>
            <?php endif; ?>
            <div class="user-fast-buttons clearfix">
                <?php if ($this->friendButton && $this->user->id != Yii::app()->user->id): ?>
                <?php Yii::app()->controller->renderPartial('//user/_friend_button', array(
                    'user' => $this->user,
                )); ?>
                <?php endif; ?>
                <?php if ($this->sendButton && $this->user->id != Yii::app()->user->id): ?>
                <?php Yii::app()->controller->renderPartial('//user/_dialog_button', array(
                    'user' => $this->user,
                )); ?>
                <?php endif; ?>
            </div>
        </div>
        <?php else: ?>
        <div class="details">
            <span class="username">Веселый Жираф</span>
        </div>
        <?php endif ?>
    <?php endif; ?>
<?php if (!$this->small): ?>
    </div>
<?php endif; ?>