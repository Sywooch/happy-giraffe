<?php
/**
 * @var \site\frontend\modules\posts\modules\contractubex\widgets\sidebarWidget\SidebarPostWidget $this
 */
?>
<li class="sidebar-promo-latest_item">
    <div class="sidebar-promo-latest_item_user">
        <div class="sidebar-promo-latest_item_user_img">
            <span class="ava ava ava__<?=($this->model->user->gender) ? 'male' : 'female'?>">
                <?php if ($this->model->user->avatarUrl): ?>
                    <img alt="<?=$this->model->user->fullName?>" src="<?=$this->model->user->avatarUrl?>" class="ava_img">
                <?php endif; ?>
            </span>
        </div>
        <span class="sidebar-promo-latest_item_user_name"><?=$this->model->user->fullName?></span>
    </div>
    <?php if ($this->photo): ?>
    <div class="sidebar-promo-latest_item_thumbnail">
        <img src="<?=Yii::app()->thumbs->getThumb($this->getPhoto(), 'postAnnouncement')?>">
    </div>
    <?php endif; ?>
    <a class="sidebar-promo-latest_item_heading" href="<?=$this->model->url?>"><?=$this->model->title?></a>
</li>