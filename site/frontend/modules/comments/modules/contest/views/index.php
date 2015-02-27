<?php
    $cs = Yii::app()->clientScript;
    $cs->registerAMD('contestCommentsIndex', array('kow'));
?>
<!-- описание конкурса-->
<div class="contest-commentator-desc">
    <div class="contest-commentator-desc_hold">
        <h3 class="contest-commentator-desc_t">Что нужно для участия?</h3>
        <div class="contest-commentator-desc_tx">Все очень легко! Просто добавляйте комментарии к тому , что вам интересно, отвечайте на комментарии других.</div>
        <h3 class="contest-commentator-desc_t">Как стать лидером?</h3>
        <div class="contest-commentator-desc_tx">Для того чтобы стать лидером нужно написать много интересных и полезных комментариев.</div><a href="<?=$this->createUrl('/comments/contest/default/rules', array('contestId' => $this->contest->id))?>" class="contest-commentator-desc_a">Полные правила и рекомендации</a>
    </div>
    <div class="contest-commentator-desc_btn-hold"> <a href="#" class="btn btn-xxxl contest-commentator_btn-orange">Принять участие!</a></div>
</div>
<!-- описание конкурса-->
<!-- призы-->
<div class="contest-commentator-prize">
    <h2 class="contest-commentator_t">Призы победителям!</h2>
    <div class="contest-commentator-prize_img"><img src="/lite/images/contest/commentator/contest-commentator-prize_img.jpg" alt=""></div>
    <div class="contest-commentator-prize_sub">

        Лучшим 10 комментаторам зачисляется <br>1000 рублей на мобильный телефон!
    </div>
    <div class="contest-commentator-prize_btn-hold"><a href="#" class="btn btn-xxxl contest-commentator_btn-orange">Хочу приз!</a></div>
</div>
<!-- призы-->
<contest-comments params="contestId: <?=$this->contest->id?>"></contest-comments>
<!-- рейтинг-->
<!-- .contest-commentator-rating__main-->
<div class="contest-commentator-rating contest-commentator-rating__main">
    <div class="contest-commentator-rating_hold">
        <h2 class="contest-commentator_t"> <span class="contest-commentator-rating_ico-cap"></span>Лидеры конкурса
        </h2>
        <ul class="contest-commentator-rating_ul">
            <li class="contest-commentator-rating_li">
                <div class="contest-commentator-rating_place contest-commentator-rating_place__big">1
                </div>
                <div class="contest-commentator-rating_user"><a href="#" class="contest-commentator-rating_user-a">
                        <!-- ava--><span href="#" class="ava"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></span><a href="#" class="contest-commentator-rating_name"> Ангелина Богоявленская</a></a></div>
                <div class="contest-commentator-rating_count">
                    <div class="contest-commentator-rating_buble"></div>99 456
                </div>
            </li>
            <li class="contest-commentator-rating_li">
                <div class="contest-commentator-rating_place contest-commentator-rating_place__big">2
                </div>
                <div class="contest-commentator-rating_user"><a href="#" class="contest-commentator-rating_user-a">
                        <!-- ava--><span href="#" class="ava"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></span><a href="#" class="contest-commentator-rating_name"> @@@@Ангелина Богоявленская@@@@</a></a></div>
                <div class="contest-commentator-rating_count">
                    <div class="contest-commentator-rating_buble"></div>19 456
                </div>
            </li>
            <li class="contest-commentator-rating_li">
                <div class="contest-commentator-rating_place contest-commentator-rating_place__big">3
                </div>
                <div class="contest-commentator-rating_user"><a href="#" class="contest-commentator-rating_user-a">
                        <!-- ava--><span href="#" class="ava"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></span><a href="#" class="contest-commentator-rating_name"> гелина Богоя</a></a></div>
                <div class="contest-commentator-rating_count">
                    <div class="contest-commentator-rating_buble"></div>9 456
                </div>
            </li>
            <li class="contest-commentator-rating_li">
                <div class="contest-commentator-rating_place contest-commentator-rating_place__big">4
                </div>
                <div class="contest-commentator-rating_user"><a href="#" class="contest-commentator-rating_user-a">
                        <!-- ava--><span href="#" class="ava"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></span><a href="#" class="contest-commentator-rating_name"> Татьяна Владимировна ☺♥♥ Родионова</a></a></div>
                <div class="contest-commentator-rating_count">
                    <div class="contest-commentator-rating_buble"></div>3 456
                </div>
            </li>
            <li class="contest-commentator-rating_li">
                <div class="contest-commentator-rating_place contest-commentator-rating_place__big">5
                </div>
                <div class="contest-commentator-rating_user"><a href="#" class="contest-commentator-rating_user-a">
                        <!-- ava--><span href="#" class="ava"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></span><a href="#" class="contest-commentator-rating_name"> Татьяна Владимировна ☺♥♥ Родионова</a></a></div>
                <div class="contest-commentator-rating_count">
                    <div class="contest-commentator-rating_buble"></div>3 456
                </div>
            </li>
        </ul>
    </div>
    <div class="contest-commentator-rating_btn-hold"><a href="#" class="btn btn-xl contest-commentator-rating_btn">Смотреть весь рейтинг</a></div>
</div>
<!-- /рейтинг-->
