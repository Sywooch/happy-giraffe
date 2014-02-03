<?php
/**
 * @var UserInfoWidget $this
 * @var int[] $counts
 */
?>

<div class="b-user b-user__w300">
    <div class="b-user_ava">
        <?php $this->widget('site.frontend.widgets.userAvatarWidget.Avatar', array('user' => $this->user, 'size' => 40)); ?>
    </div>
    <div class="b-user_hold">
        <div class="b-user_row">
            <a class="b-user_name" href="<?=$this->user->getUrl()?>"><?=$this->user->getFullName()?></a>
        </div>
        <a class="b-user_view" href="javascript:void(0)"><?=$counts[AntispamCheck::STATUS_UNDEFINED]?></a>
        <a class="b-user_check" href="javascript:void(0)"><?=$counts[AntispamCheck::STATUS_GOOD]?></a>
        <a class="b-user_del" href="javascript:void(0)"><?=$counts[AntispamCheck::STATUS_BAD]?></a>
    </div>
</div>