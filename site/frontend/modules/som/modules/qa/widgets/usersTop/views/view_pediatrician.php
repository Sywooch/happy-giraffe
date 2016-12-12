<?php
/**
 * @var \site\frontend\modules\posts\modules\forums\widgets\usersTop\UsersTopWidget $this
 * @var array $rows
 */

function getColorClass($position)
{
    switch ($position)
    {
        case 1:
            return 'b-sidebar__place--yellow';
        case 2:
            return 'b-sidebar__place--blue';
        case 3:
            return 'b-sidebar__place--green';
        default:
            return 'b-sidebar__place--white';
    }
}
?>

<?php /**
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
**/?>
 <div class="b-text--left b-margin--bottom_40">
            <div class="b-sidebar-widget">
                <div class="b-sidebar-widget__header b-sidebar-widget-header b-sidebar-widget-header--green">
                    <div class="b-sidebar-widget-header__title b-sidebar-widget-header-title b-sidebar-widget-header-title--white"><?=$this->getTitle()?></div>
                </div>
                <ul class="b-sidebar-widget__body b-sidebar b-sidebar-widget__body--green">
                	<?php foreach ($rows as $i => $row): ?>
                    <li class="b-sidebar__item">
                        <div class="b-sidebar__place"><span class="<?=getColorClass($i+1)?>"><?=$i > 2 ? $i+1 : ''?></span>
                        </div>
                        <div class="b-sidebar__content b-sidebar-content b-sidebar-content--mod">
                            <div class="b-sidebar-content__box">
                                <a href="<?=$row['user']->profileUrl?>" class="ava ava--style ava--medium ava--default">
                                    <img src="<?=$row['user']->avatarUrl?>" class="ava__img" />
                                </a>
                            </div>
                            <div class="b-sidebar-content__box">
                            	<a href="<?=$row['user']->profileUrl?>" class="b-sidebar-content__link b-sidebar-content__link--white"><?=$row['user']->fullName?></a>
                            	<span class="b-sidebar-content__answer b-sidebar-content__answer--white"> Ответы 44</span>
                                <span class="b-sidebar-content__thank b-sidebar-content__thank--white">24</span>
                            </div>
                        </div>
                        <div class="b-sidebar__right b-text--right">
                            <div class="b-sidebar__num b-sidebar__num--white"><?=intval($row['score'])?></div>
                            <div class="b-sidebar__balls b-sidebar__balls--white">баллов</div>
                        </div>
                    </li>
                	<?php endforeach; ?>
                </ul>
            </div>
        </div>

