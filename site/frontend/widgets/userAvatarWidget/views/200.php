<?php
/**
 * @var $this Avatar
 */
?><div class="b-ava-large">
    <div class="b-ava-large_ava-hold clearfix">

        <a href="<?=$this->user->getUrl()?>" class="ava large">
            <?=CHtml::image($this->user->getAvatarUrl(Avatar::SIZE_LARGE))?>
        </a>

        <?php if ($this->user->online):?>
            <span class="b-ava-large_online">На сайте</span>
        <?php endif ?>

        <?php if ($this->message_link && Yii::app()->user->id != $this->user->id):?>
            <a href="<?=$this->user->getDialogUrl()?>" class="b-ava-large_bubble b-ava-large_bubble__dialog powertip" title="Начать диалог">
                <span class="b-ava-large_ico b-ava-large_ico__mail"></span>
                <span class="b-ava-large_bubble-tx">+5</span>
            </a>
        <?php endif ?>

        <a href="<?=$this->user->getPhotosUrl()?>" class="b-ava-large_bubble b-ava-large_bubble__photo powertip" title="Фотографии">
            <span class="b-ava-large_ico b-ava-large_ico__photo"></span>
            <span class="b-ava-large_bubble-tx">+<?=$this->user->getPhotosCount() ?></span>
        </a>

        <?php if ($this->blog_link): ?>
            <?php $blogUrl = $this->user->getBlogUrl(); if ($blogUrl !== false): ?>
            <a href="<?=$this->user->getBlogUrl()?>" class="b-ava-large_bubble b-ava-large_bubble__blog powertip" title="Записи в блоге">
                <span class="b-ava-large_ico b-ava-large_ico__blog"></span>
                <span class="b-ava-large_bubble-tx">+<?=$this->user->blogPostsCount ?></span>
            </a>
            <?php endif ?>
        <?php endif ?>

        <?php if (!Friend::model()->areFriends($this->user->id, Yii::app()->user->id) && Yii::app()->user->id != $this->user->id && !FriendRequest::model()->pendingRequestExists(Yii::app()->user->id, $this->user->id)):?>
            <a href="javascript:;" onclick="inviteFriend(this, <?=$this->user->id?>, function(el) {$(el).addClass('friends-list_bubble__friend-added'); $(el).find('span').addClass('friends-list_ico__friend-added');})" class="b-ava-large_bubble b-ava-large_bubble__friend-add powertip" title="Добавить в друзья">
                <span class="b-ava-large_ico b-ava-large_ico__friend-add"></span>
            </a>
        <?php endif ?>
    </div>
    <div class="textalign-c">
        <a href="<?=$this->user->getUrl() ?>" class="b-ava-large_a"><?=$this->user->getFullName() ?></a>
        <?php if ($this->age):?>
            <span class="font-smallest color-gray"><?=$this->user->getNormalizedAge() ?></span>
        <?php endif ?>
    </div>
    <?php if ($this->location):?>
        <div class="b-ava-large_location">
            <?php
            if (!empty($this->user->address->country_id))
                echo $this->user->address->getFlag(false, 'span') . ' ' . $this->user->address->country->name;
            if (!empty($this->user->address->city_id) || !empty($this->user->address->region_id))
                echo ', ' . $this->user->address->getUserFriendlyLocation();
            ?>
        </div>
    <?php endif ?>
</div>