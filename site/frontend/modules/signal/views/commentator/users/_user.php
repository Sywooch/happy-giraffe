<?php
/* @var $this Controller
 * @var $data User
 */
?>
<div class="newcomers_i">
    <div class="user-info clearfix">
        <a class="ava <?=$data->gender?'male':'female'?>"><img src="<?=$data->getAva() ?>" alt=""></a>
        <div class="user-info_details">
            <?php if ($data->online):?>
                <div class="online-status">На сайте</div>
            <?php endif ?>
            <br>
            <a href="<?=$data->url ?>" class="user-info_username" target="_blank"><?=CHtml::encode($data->fullName) ?></a>

            <?php if ($data->address->country !== null): ?>
                <div class="user-info_location">
                    <div class="flag flag-<?= $data->address->country->iso_code; ?>"></div>
                    <?= CHtml::encode($data->address->getCityOrRegion()); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <a href="javascript:;" class="newcomers_add-friend" data-id="<?=$data->id ?>">в друзья</a>
</div>
