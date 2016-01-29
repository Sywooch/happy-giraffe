<li class="club-promo-onair_items_item clearfix">
    <div class="club-promo-onair_items_item_top clearfix">
        <div class="promo-like-badge">
            <div class="promo-like-badge_img"></div>
        </div>
        <a href="<?=$data->user->profileUrl?>" class="ava ava ava__<?=($data->user->gender) ? 'male' : 'female'?>">
            <?php if ($data->user->isOnline): ?>
                <span class="ico-status ico-status__online"></span>
            <?php endif; ?>
            <?php if ($data->user->avatarUrl): ?>
                <img alt="" src="<?=$data->user->avatarUrl?>" class="ava_img">
            <?php endif; ?>
        </a>
        <div class="username">
            <a href="<?=$data->user->profileUrl?>"><?=$data->user->fullName?></a>
            <?=HHtml::timeTag($data, array('class' => 'tx-date'))?>
        </div>
    </div>
    <div class="club-promo-onair_items_item_bottom">
        <a href="<?=$data->url?>" class="club-promo-onair_items_item_bottom_heading"><?=$data->title?></a>
        <div class="club-promo-onair_items_item_bottom_arrow"></div>
        <div class="club-promo-onair_items_item_bottom_text">
            <?=\site\common\helpers\HStr::truncate($data->text, 300)?>
        </div>
    </div>
</li>