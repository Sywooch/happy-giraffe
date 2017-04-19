<?php
use \site\frontend\modules\iframe\components\QaRatingManager;
$flowerCount = (new QaRatingManager())->getViewCounters($data['user']->id)["flowerCount"];
$avatarUrl = $data['user']->avatarInfo['big'];
if(empty($avatarUrl)){
    $avatarUrl = '/app/builds/static/img/assets/ava/ava-default.svg';
}
?>

<li class="b-pediatrician-list-item">
    <a href="<?=$data['user']->profileUrl?>" class="b-pediatrician-list-item_link">
        <div class="b-pediatrician-list-item_ava" style="background-image: url('<?=$avatarUrl?>')"></div>
        <div class="b-pediatrician-list-item_name"><?=$data['user']->fullName?></div>
        <div class="b-pediatrician-list-item_orange"><?=$data['user']->specialistInfo['title']?></div>
        <div class="b-pediatrician-list-item_city"><?=$data['user']->city?></div>
        <div class="b-pediatrician-list-item_box">
            <div class="b-pediatrician-list-item_cell">
                <span class="b-pediatrician-list-item_count"><?=$data['answers']?></span>
                <span class="b-pediatrician-list-item_gray">Ответы</span>
            </div>
            <?php if ($flowerCount > 0): ?>
                <div class="b-pediatrician-list-item_cell">
                    <span class="b-pediatrician-list-item_count"><?=$data['votes']?></span>
                    <span class="b-pediatrician-list-item_gray">
                        <?php for($i=0; $i < $flowerCount; $i++){?>
                            <span class="b-answer-header-box__ico"></span>
                        <?php } ?>
                        Спасибо
                    </span>
                </div>
            <?php endif; ?>
        </div>
    </a>
</li>