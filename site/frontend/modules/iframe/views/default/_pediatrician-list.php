<?php
use \site\frontend\modules\iframe\components\QaRatingManager;
$flowerCount = (new QaRatingManager())->getViewCounters($data->id)["flowerCount"];
$avatarUrl = $data->getAvatarUrl(200);
if(empty($avatarUrl)){
    $avatarUrl = '/app/builds/static/img/assets/ava/ava-default.svg';
}
$answers = isset($data->rating->answers_count) ? $data->rating->answers_count : 0;
$votes = isset($data->rating->votes_count) ? $data->rating->votes_count : 0;
?>

<li class="b-pediatrician-list-item">
    <a href="<?=$data->profileUrl?>" class="b-pediatrician-list-item_link">
        <div class="b-pediatrician-list-item_ava" style="background-image: url('<?=$avatarUrl?>')"></div>
        <div class="b-pediatrician-list-item_name"><?=$data->fullName?></div>
        <div class="b-pediatrician-list-item_orange"><?=$data->specialistInfoObject->title?></div>
        <div class="b-pediatrician-list-item_city"><?=$data->city?></div>
        <div class="b-pediatrician-list-item_box">
            <div class="b-pediatrician-list-item_cell">
                <span class="b-pediatrician-list-item_count"><?=$answers?></span>
                <span class="b-pediatrician-list-item_gray">Ответы</span>
            </div>
            <?php if ($flowerCount > 0): ?>
                <div class="b-pediatrician-list-item_cell">
                    <span class="b-pediatrician-list-item_count"><?=$votes?></span>
                    <span class="b-pediatrician-list-item_gray">
                        <?php for($i=0; $i < $flowerCount; $i++){?>
                            <span class="b-answer-header-box__ico"></span>
                        <?php } ?>
                        &nbsp;
                        Спасибо
                    </span>
                </div>
            <?php endif; ?>
        </div>
    </a>
</li>
