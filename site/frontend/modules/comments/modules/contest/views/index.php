<?php
$this->pageTitle = 'Лучший комментатор - О конкурсе';
$cs = Yii::app()->clientScript;
$cs->registerAMD('contestCommentsIndex', array('kow'));
$cs->registerAMD('contestCommentsButton', array('joinOrAuth' => 'extensions/joinOrAuth', 'ContestComments' => 'models/ContestComments'), 'joinOrAuth(".contest-commentator_btn-orange", ContestComments);');
?>
<!-- описание конкурса-->
<div class="contest-commentator-desc">
    <div class="contest-commentator-desc_hold">
        <h3 class="contest-commentator-desc_t">Что нужно для участия?</h3>
        <div class="contest-commentator-desc_tx">Все очень просто! Добавляйте комментарии к тому, что вам нравится и отвечайте на комментарии других.</div>
        <h3 class="contest-commentator-desc_t">Как стать лидером?</h3>
        <div class="contest-commentator-desc_tx">Для того чтобы стать лидером нужно написать много интересных и полезных комментариев.</div><a href="#" class="contest-commentator-desc_a">Полные правила и рекомендации</a>
    </div>
    <?php if (Yii::app()->user->isGuest || ! $this->contest->isRegistered(Yii::app()->user->id)): ?>
        <div class="contest-commentator-desc_btn-hold"> <a href="#" class="btn btn-xxxl contest-commentator_btn-orange" data-bind="joinOrAuthBind: {}">Принять участие!</a></div>
    <?php endif; ?>
</div>
<!-- описание конкурса-->
<!-- призы-->
<div class="contest-commentator-prize">
    <h2 class="contest-commentator_t">Призы победителям!</h2>
    <div class="contest-commentator-prize_img"><img src="/lite/images/contest/commentator/contest-commentator-prize_img.jpg" alt=""></div>
    <div class="contest-commentator-prize_sub">

        Лучшим 10 комментаторам зачисляется <br>1000 рублей на мобильный телефон!
    </div>
    <?php if (Yii::app()->user->isGuest || ! $this->contest->isRegistered(Yii::app()->user->id)): ?>
        <div class="contest-commentator-prize_btn-hold"><a href="#" class="btn btn-xxxl contest-commentator_btn-orange">Хочу приз!</a></div>
    <?php endif; ?>
</div>
<!-- призы-->
<contest-comments params="contestId: <?=$this->contest->id?>"></contest-comments>
<!-- рейтинг-->
<contest-rating params="contestId: <?=$this->contest->id?>, main: true"></contest-rating>
