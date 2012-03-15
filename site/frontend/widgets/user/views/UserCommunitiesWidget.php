<div class="user-clubs clearfix">

    <div class="box-title">Клубы <a href="<?php echo Yii::app()->createUrl('user/clubs', array('user_id' => $user->id)); ?>">Все клубы (<?php echo $count; ?>)</a></div>

    <ul>
        <?php foreach ($communities as $c): ?>
            <li class="club-img kids">
                <a href="<?php echo $c->url; ?>">
                    <img src="/images/club_img_<?php echo $c->id; ?>.png" />
                    <?php echo $c->name; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

</div>