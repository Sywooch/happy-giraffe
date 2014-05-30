<?php
/**
 * @var $this Avatar
 */
?><div class="b-ava-large">
    <div class="b-ava-large_ava-hold clearfix">

        <a href="<?=$this->user->getUrl()?>" class="ava ava__<?=($this->user->gender == 0)?'female':'male' ?> ava__large">
            <?=CHtml::image($this->user->getAvatarUrl(Avatar::SIZE_LARGE), '', array('class' => 'ava_img'))?>
        </a>

        <?php if ($this->user->online):?>
            <span class="b-ava-large_online">На сайте</span>
        <?php endif ?>

        <?php if ($this->message_link && Yii::app()->user->id != $this->user->id):?>
            <a href="<?=$this->user->getDialogUrl()?>" class="b-ava-large_bubble b-ava-large_bubble__dialog powertip" title="Начать диалог">
                <span class="b-ava-large_ico b-ava-large_ico__mail"></span>
            </a>
        <?php endif ?>

        <?php if ($this->user->getPhotosCount() > 1):?>
            <a href="<?=$this->user->getPhotosUrl()?>" class="b-ava-large_bubble b-ava-large_bubble__photo powertip" title="Фотографии">
                <span class="b-ava-large_ico b-ava-large_ico__photo"></span>
                <span class="b-ava-large_bubble-tx"><?=$this->user->getPhotosCount() ?></span>
            </a>
        <?php endif ?>

        <?php if ($this->blog_link && $this->user->hasBlogPosts()): ?>
            <?php $blogUrl = $this->user->getBlogUrl(); if ($blogUrl !== false): ?>
                <a href="<?=$this->user->getBlogUrl()?>" class="b-ava-large_bubble b-ava-large_bubble__blog powertip" title="Записи в блоге">
                    <span class="b-ava-large_ico b-ava-large_ico__blog"></span>
                    <span class="b-ava-large_bubble-tx"><?=$this->user->blogPostsCount ?></span>
                </a>
            <?php endif ?>
        <?php endif ?>

        <?php $this->widget('application.widgets.friendButtonWidget.FriendButtonWidget', array('user' => $this->user)); ?>
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