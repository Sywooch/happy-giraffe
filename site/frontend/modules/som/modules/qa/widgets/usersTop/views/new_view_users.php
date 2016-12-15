<?php
/**
 * @var \site\frontend\modules\posts\modules\forums\widgets\usersTop\UsersTopWidget $this
 * @var array $rows
 */

function getColorClassViewUsers($position)
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

<div class="b-text--left b-margin--bottom_40">
    <div class="b-sidebar-widget">
        <div class="b-sidebar-widget__header b-sidebar-widget-header b-sidebar-widget-header--green">
            <div class="b-sidebar-widget-header__title b-sidebar-widget-header-title b-sidebar-widget-header-title--white"><?=$this->getTitle()?></div>
        </div>
        <ul class="b-sidebar-widget__body b-sidebar b-sidebar-widget__body--green">
        	<?php foreach ($rows as $i => $row): ?>
            <li class="b-sidebar__item">
                <div class="b-sidebar__place"><span class="<?=getColorClassViewUsers($i+1)?>"><?=$i > 2 ? $i+1 : ''?></span>
                </div>
                <div class="b-sidebar__content b-sidebar-content b-sidebar-content--mod">
                    <div class="b-sidebar-content__box">
                        <a href="<?=$row['user']->profileUrl?>" class="ava ava--style ava--medium ava--default">
                            <img src="<?=$row['user']->avatarUrl?>" class="ava__img" />
                        </a>
                    </div>
                    <div class="b-sidebar-content__box">
                    	<a href="<?=$row['user']->profileUrl?>" class="b-sidebar-content__link b-sidebar-content__link--white"><?=$this->formattedName($row['user']->fullName)?></a>
                    	<span class="b-sidebar-content__answer b-sidebar-content__answer--white"> Ответы <?=$row['answers']?></span>
                        <span class="b-sidebar-content__thank b-sidebar-content__thank--white"><?=$row['votes']?></span>
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

