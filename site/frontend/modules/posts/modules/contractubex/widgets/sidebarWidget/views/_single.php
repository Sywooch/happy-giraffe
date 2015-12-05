<?php
/**
 * @var \site\frontend\modules\posts\modules\contractubex\widgets\sidebarWidget\SidebarPostWidget $this
 */
?>
<li class="sidebar-promo-latest_item">
    <div class="sidebar-promo-latest_item_user">
        <div class="sidebar-promo-latest_item_user_img">
            <a href="<?=$this->model->user->profileUrl?>" class="ava ava ava__<?=($this->model->user->gender) ? 'male' : 'female'?>">
                <?php if ($this->model->user->avatarUrl): ?>
                    <img alt="<?=$this->model->user->fullName?>" src="<?=$this->model->user->avatarUrl?>" class="ava_img">
                <?php endif; ?>
            </a>
        </div>
        <a class="sidebar-promo-latest_item_user_name" href="<?=$this->model->user->profileUrl?>"><?=$this->model->user->fullName?></a>
    </div>
    <?php if ($this->photo): ?>
    <div class="sidebar-promo-latest_item_thumbnail">
        <img src="<?=Yii::app()->thumbs->getThumb($this->getPhoto(), 'postAnnouncement')?>">
    </div>
    <?php endif; ?>
    <a class="sidebar-promo-latest_item_heading"><?=$this->model->title?></a>
</li>