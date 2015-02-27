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
<!-- комментарии-->
<div class="contest-commentator-list">
    <div class="contest-commentator_t">Последние комментарии
        <!-- active добавлять для отображения загрузки, по умолчанию без этого класса--><a href="#" class="contest-commentator-list_load active"> </a>
    </div>
    <div class="contest-commentator-list_hold">
        <!-- comments-->
        <section class="comments comments__buble">
            <div class="comments_hold">
                <ul class="comments_ul">
                    <!--
                    варианты цветов комментов. В такой последовательности
                    .comments_li__lilac
                    .comments_li__yellow
                    .comments_li__red
                    .comments_li__blue
                    .comments_li__green
                    -->
                    <li class="comments_li comments_li__lilac">
                        <div class="comments_i clearfix">
                            <div class="comments_ava">
                                <!-- Аватарки размером 40*40-->
                                <!-- ava--><a href="#" class="ava ava__middle ava__small-xs"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/189385/74c3062ab78a806abc8d3a3e8990bf0e.jpg" class="ava_img"></a>
                            </div>
                            <div class="comments_frame">
                                <div class="comments_header"><a href="#" rel="author" class="a-light comments_author"> Иванна Хлебникова</a>
                                    <time datetime="2012-12-23" class="tx-date">2 минуты назад</time>
                                </div>
                                <div class="comments_cont">
                                    <div class="wysiwyg-content">
                                        <p>

                                            Ну не все. Я видео скидыавала Лере Догузовой про матрешек вот это более правдивое представление.  Неотесанное быдло которое не умеет себя вести и это не Россия а и Украина тоже!
                                        </p>
                                        <!-- одно фото в блок (ссылку)--><a href="#" class="comments_cont-img-w">
                                            <!-- размеры превью максимум 400*400 пк--><img alt="" src="/images/example/w220-h309-1.jpg" class="content-img"></a>
                                        <p>Меняя название трека в альбоме он автоматически производит поиск по сайту и подцепляет естественно студийные версии песен вместо нужных.</p>
                                    </div>
                                </div>
                                <div class="from-article-s clearfix">
                                    <div class="from-article-s_ava">
                                        <!-- ava--><a href="#" class="ava ava__small"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a>
                                    </div>
                                    <div class="from-article-s_hold">
                                        <div class="from-article-s_head"><a href="#" class="a-light">Ангелина Богоявленская</a>
                                            <time datetime="2012-12-23" class="tx-date">2 минуты назад</time>
                                        </div><a href="#" class="from-article-s_t">Я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!-- / комментарий  -->
                    <!-- комментарий     -->
                    <li class="comments_li comments_li__red">
                        <div class="comments_i clearfix">
                            <div class="comments_ava">
                                <!-- Аватарки размером 40*40-->
                                <!-- ava--><a href="#" class="ava ava__middle ava__small-xs"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a>
                            </div>
                            <div class="comments_frame">
                                <div class="comments_header"><a href="#" rel="author" class="a-light comments_author"> Иванна Хлебникова</a>
                                    <time datetime="2014-11-04T18:20:54+00:00" class="tx-date">2 минуты назад</time>
                                </div>
                                <div class="comments_cont">
                                    <div class="wysiwyg-content">
                                        <p>Меняя название трека в альбоме он автоматически производит поиск по сайту и подцепляет естественно студийные версии песен вместо нужных.</p>
                                    </div>
                                </div>
                                <div class="from-article-s clearfix">
                                    <div class="from-article-s_ava">
                                        <!-- ava--><a href="#" class="ava ava__small"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a>
                                    </div>
                                    <div class="from-article-s_hold">
                                        <div class="from-article-s_head"><a href="#" class="a-light">Ангелина Богоявленская</a>
                                            <time datetime="2012-12-23" class="tx-date">2 минуты назад</time>
                                        </div><a href="#" class="from-article-s_t">Я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </section>
    </div>
</div>
<!-- /комментарии-->
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