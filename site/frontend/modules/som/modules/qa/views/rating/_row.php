<?php
/**
 * @var site\frontend\modules\som\modules\qa\models\QaUserRating $data
 * @var LiteListView $widget
 * @var int $index
 */
$class = 'nocrown';
if ($widget->dataProvider->getPagination()->currentPage == 0 && $index < 3) {
    switch ($index) {
        case 0:
            $class = 'yellow-crown';
            break;
        case 1:
            $class = 'blue-crown';
            break;
        case 2:
            $class = 'orange-crown';
            break;
    }
}
?>

<li class="faq-rating_item">
    <a href="<?=$data->user->profileUrl?>" class="ava ava ava__female">
        <?php if ($data->user->isOnline): ?>
            <span class="ico-status ico-status__online"></span>
        <?php endif; ?>
        <?php if ($data->user->avatarUrl): ?>
            <img alt="" src="<?=$data->user->avatarUrl?>" class="ava_img">
        <?php endif; ?>
    </a>
    <a class="faq-rating_item_link"><?=$data->user->fullName?></a>
    <div class="faq-rating_item_counters"><span>Вопросов <?=$data->questionsCount?></span><span>Ответов <?=$data->answersCount?></span></div>
    <div class="users-rating <?=$class?>">
        <div class="users-rating_crown-big"></div>
        <div class="users-rating_counter"><?=round($data->rating)?></div>
    </div>
    <div class="clearfix"></div>
</li>