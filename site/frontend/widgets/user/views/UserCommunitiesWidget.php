<div class="user-clubs clearfix">

    <div class="box-title">Клубы <a href="<?php echo Yii::app()->createUrl('user/clubs', array('user_id' => $user->id)); ?>">Все клубы (<?php echo $count; ?>)</a></div>

    <ul>
        <?php foreach ($communities as $c): ?>
            <li class="club-img <?=$c->css_class ?>">
                <a href="<?php echo $c->url; ?>">
                    <img src="/images/club_img_<?php echo $c->position; ?>.png" />
                    <?php echo $c->title; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

</div>