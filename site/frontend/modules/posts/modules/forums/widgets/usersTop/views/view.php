<?php
/**
 * @var \site\frontend\modules\posts\modules\forums\widgets\usersTop\UsersTopWidget $this
 * @var array $rows
 */
$classes = ['one', 'two', 'three', 'four', 'five'];
?>

<li class="forummen-month">
    <div class="head">форумчанин <?=\Yii::app()->dateFormatter->format('MMMM', $this->getTime())?></div>
    <?php foreach ($rows as $i => $row): ?>
    <div class="b-user">
        <div class="b-user-number <?=(isset($classes[$i]) ? $classes[$i] : '')?>"><?=($i+1)?></div>
        <div class="b-user-ava"><img src="/images/icons/ava.jpg" alt=""></div>
        <div class="b-user-name"><?=$row['user']->fullName?></div>
        <div class="b-user-rating"><span><?=$row['score']?></span>баллов</div>
    </div>
    <?php endforeach; ?>
</li>