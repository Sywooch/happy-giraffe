<?php
/**
 * @var \site\frontend\modules\posts\modules\forums\widgets\usersTop\UsersTopWidget $this
 * @var array $rows
 */
if (!function_exists('getColorClassViewSpecialists')) {
    function getColorClassViewSpecialists($position)
    {
        switch ($position) {
            case 1:
                return 'b-sidebar__place--yellow';
            case 2:
                return 'b-sidebar__place--blue';
            case 3:
                return 'b-sidebar__place--green';
            default:
                return 'b-sidebar__place--grey';
        }
    }
}
?>
<ul class="b-sidebar-widget__body b-sidebar">
    <?php foreach ($rows as $i => $row): ?>
        <li class="b-sidebar__item">
            <a href="<?=$row['user']->profileUrl?>" class="b-sidebar-widget__table">
                <div class="b-sidebar__place"><span class="<?=getColorClassViewSpecialists($i+1)?>"><?=$i > 2 ? $i+1 : ''?></span>
                </div>
                <div class="b-sidebar__content b-sidebar-content b-sidebar-content--mod">
                    <div class="b-sidebar-content__box">
                    <span class="ava ava--style ava--medium ava--default">
                        <img src="<?=$row['user']->avatarUrl?>" class="ava__img" />
                    </span>
                    </div>
                    <div class="b-sidebar-content__box">
                        <span class="b-sidebar-content__link"><?=$this->formattedName($row['user']->fullName)?></span>
                        <span class="b-sidebar-content__answer b-sidebar-content__answer--grey"> Ответы <?=$row['answers']?></span>
                        <span class="b-sidebar-content__thank b-sidebar-content__thank--grey"><?=$row['votes']?></span>
                    </div>
                </div>
                <div class="b-sidebar__right b-text--right">
                    <div class="b-sidebar__num b-sidebar__num--grey"><?=intval($row['score'])?></div>
                    <div class="b-sidebar__balls b-sidebar__balls--grey"><?=\Yii::t('app', 'балл|балла|баллов|балла', intval($row['score']))?></div>
                </div>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
