<li class="b-family_li">
    <div class="b-family_img-hold">
        <?php if (count($user->partner->photos) > 0):?>
            <?php if ($user->partner->randomPhoto !== null): ?>
            <?=CHtml::image($user->partner->randomPhoto->photo->getPreviewUrl(53, 53), $user->partner->name)?>
            <?php endif; ?>
        <?php else: ?>
            <?php
            switch($user->relationship_status){
                case 1:
                    $class = ($user->gender == 0)?'husband':'wife';
                    break;
                case 3:
                    $class = ($user->gender == 0)?'fiance':'bride';
                    break;
                case 4:
                    $class = ($user->gender == 0)?'boy-friend':'girl-friend';
                    break;
                default: $class = 'husband';
            }
            ?>
            <div class="ico-family ico-family__<?=$class ?>"></div>
        <?php endif ?>
    </div>
    <div class="b-family_tx">
    <span><?=$user->partnerTitleNew?></span> <br />
    <?php if (! empty($user->partner->name)): ?>
        <span><?=$user->partner->name?></span>
    <?php endif; ?>
    </div>
</li>