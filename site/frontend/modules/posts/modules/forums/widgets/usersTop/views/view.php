<?php
/**
 * @var \site\frontend\modules\posts\modules\forums\widgets\usersTop\UsersTopWidget $this
 * @var array $rows
 */
$classes = ['one', 'two', 'three', 'four', 'five'];
?>


<div class="b-widget-wrapper b-widget-wrapper_people b-widget-wrapper_border b-widget-wrapper_forum">
    <div class="b-widget-header">
        <div class="b-widget-header__title">Форумчанин <?=\Yii::app()->dateFormatter->format('MMMM', $this->getTimeFrom())?></div>
    </div>
    <div class="b-widget-content">
        <ul class="b-widget-content__list">
            <?php foreach ($rows as $i => $row): ?>
            <li class="b-widget-content__item">
                <div class="b-widget-content__number"><?=($i+1)?></div>
                <div class="b-widget-content__ava"><img src="/images/icons/ava.jpg" alt=""></div>
                <div class="b-widget-content__name"><a href="<?=$row['user']->profileUrl?>" class="b-widget-content__link"><?=$row['user']->fullName?></a></div>
                <div class="b-widget-content__rating"><?=$row['score']?><span>баллов</span></div>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

