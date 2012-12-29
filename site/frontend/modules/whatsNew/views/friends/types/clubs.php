<?
    $communityIds = array();
    if (!Yii::app()->user->isGuest)
    foreach (Yii::app()->user->model->communities as $c)
        $communityIds[] = $c->id;
?>

<div class="clubs-list">
    <ul>
        <?php foreach ($data->clubs as $c): ?>
            <li class="club-img <?=$c->css_class?>">
                <a href="<?=$c->url?>">
                    <img src="/images/club_img_<?=$c->id?>.png">
                    <?=$c->title?>
                </a>
                <?php if (! in_array($c->id, $communityIds)): ?>
                    <a href="<?=$c->url?>" class="club-join">Вступить</a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>