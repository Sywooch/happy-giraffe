<div class="user-clubs clearfix list-item">

    <?=$this->renderPartial('activity/_activity_friend', array('user_id' => $action['user_id'], 'type' => $type))?>

    <div class="box-title"><?=($users[$action->user_id]->gender == 1) ? 'Вступил' : 'Вступила'?> в клубы</div>
    <ul>
        <?php foreach ($action->data as $club): ?>
            <?php $community = Community::model()->findByPk($club['id']) ?>
            <li class="club-img <?=$community->css_class ?>">
                <a href="<?=$this->createUrl('/community/list', array('community_id'=>$club['id'])) ?>">
                    <img src="/images/club_img_<?=$community->position?>.png">
                    <span><?=$community->title?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

</div>