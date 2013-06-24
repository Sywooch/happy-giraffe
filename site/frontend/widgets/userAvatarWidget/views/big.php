<?php
/**
 * @var $this UserAvatarWidget
 */
?><div class="b-ava-large">
    <div class="b-ava-large_ava-hold clearfix">
        <a href="<?=$this->user->getUrl()?>" class="ava large">
            <?=CHtml::image($this->user->getAva('large'))?>
        </a>
        <?php if ($this->user->online):?>
            <span class="b-ava-large_online">На сайте</span>
        <?php endif ?>
        <a href="<?=$this->user->getDialogUrl()?>" class="b-ava-large_bubble b-ava-large_bubble__dialog powertip" title="Начать диалог">
            <span class="b-ava-large_ico b-ava-large_ico__mail"></span>
<!--            <span class="b-ava-large_bubble-tx">+5</span>-->
        </a>
        <a href="<?=$this->user->getPhotosUrl()?>" class="b-ava-large_bubble b-ava-large_bubble__photo powertip" title="Фотографии">
            <span class="b-ava-large_ico b-ava-large_ico__photo"></span>
<!--            <span class="b-ava-large_bubble-tx">+50</span>-->
        </a>
        <a href="<?=$this->user->getBlogUrl()?>" class="b-ava-large_bubble b-ava-large_bubble__blog powertip" title="Записи в блоге">
            <span class="b-ava-large_ico b-ava-large_ico__blog"></span>
<!--            <span class="b-ava-large_bubble-tx">+999</span>-->
        </a>
        <?php if (!Friend::model()->areFriends($this->user->id, Yii::app()->user->id) && Yii::app()->user->id != $this->user->id && !FriendRequest::model()->pendingRequestExists(Yii::app()->user->id, $this->user->id)):?>
            <a href="javascript:;" onclick="inviteFriend(this, <?=$this->user->id?>, function(el) {$(el).addClass('friends-list_bubble__friend-added'); $(el).find('span').addClass('friends-list_ico__friend-added');})" class="b-ava-large_bubble b-ava-large_bubble__friend-add powertip" title="Добавить в друзья">
                <span class="b-ava-large_ico b-ava-large_ico__friend-add"></span>
            </a>
        <?php endif ?>
    </div>
    <div class="textalign-c">
        <a href="<?=$this->user->getUrl() ?>" class="b-ava-large_a"><?=$this->user->getFullName() ?></a>
    </div>
</div>