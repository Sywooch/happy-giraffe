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
<?php if (! $this->small): ?>
    <div class="user-info clearfix<?php if ($this->size == 'ava') echo ' medium' ?>">
<?php endif; ?>
    <?=HHtml::link($this->user->getAva($this->size)?CHtml::image($this->user->getAva($this->size)):'', $link_to_profile, array('class'=>$class), true)?>
<?php if (!$this->small): ?>
    <?php if ($this->user->id != User::HAPPY_GIRAFFE): ?>
        <div class="details">
            <span class="icon-status status-<?php echo $this->user->online == 1 ? 'online' : 'offline'; ?>"></span>
            <?=HHtml::link(CHtml::encode($this->user->fullName), $link_to_profile, array('class'=>'username'), $this->hideLinks)?>
            <?php if ($this->location && $this->user->getUserAddress()->country !== null): ?>
                <div class="location">
                    <div class="flag flag-<?php echo $this->user->getUserAddress()->country->iso_code; ?>"></div>
                    <?php echo CHtml::encode($this->user->getUserAddress()->cityName); ?>
                </div>
            <?php endif; ?>
            <div class="user-fast-buttons">
                <?php if ($this->friendRequest !== false): ?>
                    <?php if ($this->friendRequest['direction'] == 'incoming'): ?>
                        <?=CHtml::link('Принять', array('friendRequests/update', 'request_id' => $this->friendRequest['id'], 'action' => 'accept'), array('class' => 'accept'))?>
                        <?=CHtml::link('', array('friendRequests/update', 'request_id' => $this->friendRequest['id'], 'action' => 'decline'), array('class' => 'remove tooltip', 'title' => 'Отклонить'))?>
                    <?php else: ?>
                        <?=CHtml::link('Отменить', array('friendRequests/update', 'request_id' => $this->friendRequest['id'], 'action' => 'cancel'), array('class' => 'accept cancel'))?>
                    <?php endif; ?>
                <?php endif; ?>
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
            <?php if ($this->nav): ?>
                <div class="user-fast-nav">
                    <ul>
                        <?=CHtml::link('Анкета', array('/user/profile', 'user_id' => $this->user->id))?>&nbsp;|&nbsp;<?=CHtml::link('Блог', array('/blog/list', 'user_id' => $this->user->id))?>&nbsp;|&nbsp;<?=CHtml::link('Фото', array('/albums/user', 'id' => $this->user->id))?>&nbsp;|&nbsp;<?=CHtml::link('Что нового', array('/user/activity', 'user_id' => $this->user->id, 'type' => 'my'))?> &nbsp;|&nbsp;<span class="drp-list">
                            <a href="javascript:void(0)" class="more" onclick="$(this).next().toggle();">Еще</a>
                            <ul style="display: none;"">
                                <li><?=CHtml::link('Друзья', array('/user/friends', 'user_id' => $this->user->id))?></li>
                                <li><?=CHtml::link('Клубы', array('/user/clubs', 'user_id' => $this->user->id))?></li>
                            </ul>
                        </span>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
        <?php if ($this->status && $this->user->status !== null): ?>
            <div class="text-status">
                <p><?=$this->user->status->text?></p>
                <span class="tale"></span>
            </div>
        <?php endif; ?>
        <?php else: ?>
            <div class="details">
                <span class="username">Веселый Жираф</span>
            </div>
        <?php endif ?>
    <?php endif; ?>
<?php if (! $this->small): ?>
    </div>
<?php endif; ?>