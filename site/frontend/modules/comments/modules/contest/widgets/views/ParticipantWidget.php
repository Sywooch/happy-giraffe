<div class="contest-commentator-rating contest-commentator-rating__self">
    <ul class="contest-commentator-rating_ul">
        <li class="contest-commentator-rating_li">
            <?php if ($this->participant->score > 0): ?>
                <div class="contest-commentator-rating_place contest-commentator-rating_place__big"><?=$this->participant->place?></div>
            <?php endif; ?>
            <div class="contest-commentator-rating_user">
                <a href="<?=$this->participant->user->url?>" class="contest-commentator-rating_user-a">
                    <span class="ava"><img alt="" src="<?=$this->participant->user->avatarUrl?>" class="ava_img"></span>
                    <span class="contest-commentator-rating_name"><?=$this->participant->user->fullName?></span>
                </a>
            </div>
            <div class="contest-commentator-rating_count"><a href="#" class="contest-commentator-rating_buble"></a><?=$this->participant->score?></div>
        </li>
    </ul>
</div>