<?php
/**
 * @var ScoreUserAward[]|ScoreUserAchievement[] $awards
 */
?><div class="award-list">
    <ul class="award-list_ul">
        <?php foreach ($awards as $award): ?>
            <li class="award-list_li">
                <div class="award-list_img-hold">
                    <a href="<?=$award->getUrl() ?>" class="award-list_info ico-info"></a>
                    <a href="<?=$award->getUrl() ?>">
                        <img src="<?=$award->getAward()->getIconUrl(140) ?>" class="award-list_img" alt="<?=$award->getAward()->title ?>">
                    </a>
                </div>
                <div class="font-smallest color-gray"><?=Yii::app()->dateFormatter->format('d MMM yyyy',strtotime($award->created)) ?></div>
                <div class="clearfix">
                    <a href="<?=$award->getUrl() ?>" class="award-list_a"><?=$award->getAward()->title ?></a>
                </div>
                <div class="award-list_count">+ <?=$award->getAward()->scores ?> баллов</div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>