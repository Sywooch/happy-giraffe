<div class="user-clubs clearfix list-item">

    <?=$this->render('_activity_friend', array('user_id' => $action['user_id'], 'type' => $type))?>

    <div class="box-title">Вступил в клубы</div>

    <ul>
        <?php foreach ($action->data as $club): ?>
            <li class="club-img kids">
                <a href="">
                    <img src="/images/club_img_<?=$club['id']?>.png">
                    <span><?=$club['title']?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

</div>