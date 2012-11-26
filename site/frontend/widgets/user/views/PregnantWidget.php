<?php
/* @var $this Controller
 * @var $baby Baby
 */
$weeks_left = floor((strtotime($this->baby->birthday) - time()) / 604800);
$week = 40 - $weeks_left;
$url = Yii::app()->createUrl('/calendar/default/index',array('calendar' => 1,'slug' => 'week'.$week));
?><div class="user-calendar-pregnancy">
    <div class="user-calendar-pregnancy_title"><span><?=$week ?> неделя беременности</span></div>
    <div class="user-calendar-pregnancy_img">
        <img src="/images/widget/user-calendar-pregnancy/week-<?=$week ?>.jpg" alt="">
    </div>
    <div class="user-calendar-pregnancy_all clearfix">
        <a href="<?=$url ?>">Все о <?=$week ?> неделе беременности</a> <a href="<?=$url ?>" class="arrow">→</a>
    </div>
</div>