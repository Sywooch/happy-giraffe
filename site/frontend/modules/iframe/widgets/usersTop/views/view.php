<?php
/**
 * @var \site\frontend\modules\posts\modules\forums\widgets\usersTop\UsersTopWidget $this
 * @var array $rows
 */
?>

<div class="b-widget-wrapper b-widget-wrapper_people b-widget-wrapper_border b-widget-wrapper_forum">
    <div class="b-widget-header">
        <div class="b-widget-header__title"><?=$this->getTitle()?></div>
    </div>
    <div class="b-widget-content">
        <ul class="b-widget-content__list">
            <?php foreach ($rows as $i => $row): ?>
            <li class="b-widget-content__item">
                <div class="b-widget-content__number"><?=($i+1)?></div>
                <div class="b-widget-content__ava">
                    <a class="ava ava__middle ava__<?=$row['user']->gender == '1' ? 'male' : 'female'?>" href="<?=$row['user']->profileUrl?>">
                        <img class="ava_img" src="<?=$row['user']->avatarUrl?>" alt="">
                    </a>
                </div>
                <div class="b-widget-content__name"><a href="<?=$row['user']->profileUrl?>" class="b-widget-content__link"><?=$row['user']->fullName?></a></div>
                <div class="b-widget-content__rating"><?=intval($row['score'])?><span>баллов</span></div>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

