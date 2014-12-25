<?php
/**
 * @var LiteController $this
 * @var \User $user
 */
$this->pageTitle = $user->getFullName() . ' на Веселом Жирафе';
?>

<?php $this->widget('site\frontend\modules\userProfile\widgets\UserSectionWidget', array('user' => $user)); ?>

<div class="b-main_cont b-main_cont__broad">
    <div class="b-main_col-hold clearfix">
        <!--/////     -->
        <!-- Основная колонка-->
        <div class="b-main_col-article">
        <div class="heading-sm">Моя активность</div>
        <!-- Статья с текстом-->
        <!-- b-article-->
        <article class="b-article b-article__list clearfix">
            <div class="b-article_cont clearfix">
                <div class="b-article_header clearfix">
                    <div class="float-l">
                        <!-- ava--><a href="#" class="ava ava__female ava__small-xxs ava__middle-xs ava__middle-sm-mid "><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a href="#" class="b-article_author">Ангелина Богоявленская</a>
                        <time pubdate="1957-10-04" class="tx-date">Сегодня 13:25</time>
                    </div>
                    <div class="icons-meta"><a href="#" class="icons-meta_comment"><span class="icons-meta_tx">35</span></a>
                        <div class="icons-meta_view"><span class="icons-meta_tx">305</span></div>
                    </div>
                </div>
                <div class="b-article_t-list"><a href="#" class="b-article_t-a">Самое лучшее утро - просыпаюсь, а ты рядом</a></div>
                <div class="b-article_in clearfix">
                    <div class="wysiwyg-content clearfix">
                        <!-- Текстовая статья-->
                        <div class="b-article_in-img"><a href="#"><img alt="" src="/lite/images/example/w600-h415.jpg"></a></div>
                        <!-- Описание определенное количество символов-->
                        <p>Дадим ему остыть. Желе торта разводим согласно инструкции. Поломаем не небольшие кусочки крекер. Апельсин почистим и разберем на дольки. а не только лишь  <span class="ico-more"></span></p>
                    </div>
                </div>
                <!-- comments-->
                <section class="comments">
                    <div id="commentsList" class="comments_hold">
                        <ul class="comments_ul">
                            <!--
                            варианты цветов комментов. В такой последовательности
                            .comments_li__lilac
                            .comments_li__yellow
                            .comments_li__red
                            .comments_li__blue
                            .comments_li__green
                            -->
                            <li class="comments_li">
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
                                                    <!-- размеры превью максимум 400*400 пк--><img alt="" src="/images/example/w220-h309-1.jpg"></a>
                                                <p>Меняя название трека в альбоме он автоматически производит поиск по сайту и подцепляет естественно студийные версии песен вместо нужных.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <!-- / комментарий  -->
                            <!-- комментарий     -->
                            <li class="comments_li">
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
                                    </div>
                                </div>
                            </li>
                            <!-- комментарий     -->
                            <li class="comments_li">
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
                                    </div>
                                </div>
                            </li>
                            <!-- комментарий -->
                        </ul>
                    </div>
                </section>
                <!-- /comments-->
                <div class="article-also">
                    <div class="article-also_row">
                        <!-- при маленьком размере в мобильном исчезают только лайки и избранное-->
                        <div class="like-control like-control__small">
                            <div class="like-control_hold like-control_hold__comment"><a href="#" title="Комментировать" class="like-control_i powertip">
                                    <div href="#" class="ico-action-hg ico-action-hg__comment"> </div>
                                    <div class="like-control_tx">865</div></a></div>
                            <div class="like-control_hold visible-md-inline-block"><a href="#" title="Нравится" class="like-control_i powertip">
                                    <div class="ico-action-hg ico-action-hg__like"></div>
                                    <div class="like-control_tx">865</div></a></div>
                            <div class="like-control_hold visible-md-inline-block"><a href="#" title="В избранное" class="like-control_i powertip">
                                    <div class="ico-action-hg ico-action-hg__favorite"></div>
                                    <div class="like-control_tx">8634</div></a>
                                <!-- .favorites-add-popup.favorites-add-popup__right.display-n
                                .favorites-add-popup_t Добавить запись в избранное
                                .favorites-add-popup_i.clearfix
                                    img.favorites-add-popup_i-img(src='/images/example/w60-h40.jpg', alt='')
                                    .favorites-add-popup_i-hold Неравный брак. Смертельно опасен или жизненно необходим?
                                .favorites-add-popup_row
                                    label.favorites-add-popup_label(for='') Теги:
                                    span.favorites-add-popup_tag
                                        a.favorites-add-popup_tag-a(href='') отношения
                                        a.ico-close(href='#')
                                    span.favorites-add-popup_tag
                                        a.favorites-add-popup_tag-a(href='') любовь
                                        a.ico-close(href='#')
                                .favorites-add-popup_row.margin-b10
                                    a.textdec-none(href='#')
                                        span.ico-plus2.margin-r5
                                        span.a-pseudo-gray.color-gray Добавить тег
                                .favorites-add-popup_row
                                    label.favorites-add-popup_label(for='') Комментарий:
                                    .float-r.color-gray 0/150
                                .favorites-add-popup_row
                                    textarea.favorites-add-popup_textarea(name='', cols='25', rows='2', placeholder='Введите комментарий')
                                .favorites-add-popup_row.textalign-c.margin-t10
                                    a.btn-secondary.btn-s(href='#') Отменить
                                    a.btn-success.btn-s(href='#') Добавить


                                -->
                            </div>
                        </div>
                    </div>
                    <div class="article-also_row">
                        <div class="article-also_tx">Смотреть все <a href="#">комментарии</a>
                            <div class="visible-md-inline-block">,<a href="#"> нравится, </a></div>
                            <div class="visible-md-inline-block"><a href="#"> закладки </a></div>.
                        </div>
                    </div>
                </div>
            </div>
        </article>
        <!-- /b-article-->

        <!-- Статья с текстом-->
        <!-- b-article-->
        <article class="b-article b-article__list clearfix">
            <div class="b-article_cont clearfix">
                <div class="b-article_header clearfix">
                    <div class="float-l">
                        <!-- ava--><a href="#" class="ava ava__female ava__small-xxs ava__middle-xs ava__middle-sm-mid "><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a href="#" class="b-article_author">Ангелина Богоявленская</a>
                        <time pubdate="1957-10-04" class="tx-date">Сегодня 13:25</time>
                    </div>
                    <div class="icons-meta"><a href="#" class="icons-meta_comment"><span class="icons-meta_tx">35</span></a>
                        <div class="icons-meta_view"><span class="icons-meta_tx">305</span></div>
                    </div>
                </div>
                <div class="b-article_t-list"><a href="#" class="b-article_t-a">Самое лучшее утро - просыпаюсь, а ты рядом</a></div>
                <div class="b-article_in clearfix">
                    <div class="wysiwyg-content clearfix">
                        <!-- Статья видео-->
                        <div class="b-article_in-img">
                            <!-- Во всех статьях видео необходимо обвернуть в .video-container-->
                            <div class="video-container">
                                <iframe width="600" height="330" src="http://www.youtube.com/embed/IS9xI7Arrsk?wmode=transparent&amp;feature=oembed&amp;wmode=transparent" frameborder="0" allowfullscreen=""></iframe>
                            </div>
                        </div>
                        <!-- Описание определенное количество символов-->
                        <p>Дадим ему остыть. Желе торта разводим согласно инструкции. Поломаем не небольшие кусочки крекер. Апельсин почистим и разберем на дольки. а не только лишь  <span class="ico-more"></span></p>
                    </div>
                </div>
                <div class="article-also">
                    <div class="article-also_row">
                        <!-- при маленьком размере в мобильном исчезают только лайки и избранное-->
                        <div class="like-control like-control__small">
                            <div class="like-control_hold like-control_hold__comment"><a href="#" title="Комментировать" class="like-control_i powertip">
                                    <div href="#" class="ico-action-hg ico-action-hg__comment"> </div>
                                    <div class="like-control_tx">865</div></a></div>
                            <div class="like-control_hold visible-md-inline-block"><a href="#" title="Нравится" class="like-control_i powertip">
                                    <div class="ico-action-hg ico-action-hg__like"></div>
                                    <div class="like-control_tx">865</div></a></div>
                            <div class="like-control_hold visible-md-inline-block"><a href="#" title="В избранное" class="like-control_i powertip">
                                    <div class="ico-action-hg ico-action-hg__favorite"></div>
                                    <div class="like-control_tx">8634</div></a>
                                <!-- .favorites-add-popup.favorites-add-popup__right.display-n
                                .favorites-add-popup_t Добавить запись в избранное
                                .favorites-add-popup_i.clearfix
                                    img.favorites-add-popup_i-img(src='/images/example/w60-h40.jpg', alt='')
                                    .favorites-add-popup_i-hold Неравный брак. Смертельно опасен или жизненно необходим?
                                .favorites-add-popup_row
                                    label.favorites-add-popup_label(for='') Теги:
                                    span.favorites-add-popup_tag
                                        a.favorites-add-popup_tag-a(href='') отношения
                                        a.ico-close(href='#')
                                    span.favorites-add-popup_tag
                                        a.favorites-add-popup_tag-a(href='') любовь
                                        a.ico-close(href='#')
                                .favorites-add-popup_row.margin-b10
                                    a.textdec-none(href='#')
                                        span.ico-plus2.margin-r5
                                        span.a-pseudo-gray.color-gray Добавить тег
                                .favorites-add-popup_row
                                    label.favorites-add-popup_label(for='') Комментарий:
                                    .float-r.color-gray 0/150
                                .favorites-add-popup_row
                                    textarea.favorites-add-popup_textarea(name='', cols='25', rows='2', placeholder='Введите комментарий')
                                .favorites-add-popup_row.textalign-c.margin-t10
                                    a.btn-secondary.btn-s(href='#') Отменить
                                    a.btn-success.btn-s(href='#') Добавить


                                -->
                            </div>
                        </div>
                    </div>
                    <div class="article-also_row">
                        <div class="article-also_tx">Смотреть все <a href="#">комментарии</a>
                            <div class="visible-md-inline-block">,<a href="#"> нравится, </a></div>
                            <div class="visible-md-inline-block"><a href="#"> закладки </a></div>.
                        </div>
                    </div>
                </div>
            </div>
        </article>
        <!-- /b-article-->

        </div>
        <!--/////-->
        <!-- Сайд бар  -->
        <aside class="b-main_col-sidebar visible-md">
            <!-- виджет фото-->
            <div class="widget-user-photo">
                <div class="heading-sm"><a href="#" class="heading-sm_a-r">Все фото 828</a>Мои фото</div>
                <ul class="widget-user-photo_ul clearfix">
                    <li class="widget-user-photo_li"><a href="#" class="widget-user-photo_i"> <img src="http://placecreature.com/dog/300/200" alt="Заголовок фото">
                            <div class="widget-user-photo_overlay">
                                <div class="ico-zoom ico-zoom__abs"></div>
                            </div></a></li>
                    <li class="widget-user-photo_li"><a href="#" class="widget-user-photo_i"> <img src="http://placecreature.com/goldfish/110/70" alt="Заголовок фото">
                            <div class="widget-user-photo_overlay">
                                <div class="ico-zoom ico-zoom__abs ico-zoom__s"></div>
                            </div></a></li>
                    <li class="widget-user-photo_li"><a href="#" class="widget-user-photo_i"> <img src="http://placecreature.com/puppy/80/70" alt="Заголовок фото">
                            <div class="widget-user-photo_overlay">
                                <div class="ico-zoom ico-zoom__abs ico-zoom__s"></div>
                            </div></a></li>
                    <li class="widget-user-photo_li"><a href="#" class="widget-user-photo_i"> <img src="http://placecreature.com/red-panda/90/70" alt="Заголовок фото">
                            <div class="widget-user-photo_overlay">
                                <div class="ico-zoom ico-zoom__abs ico-zoom__s"></div>
                            </div></a></li>
                </ul>
            </div>
            <!-- /виджет фото-->
            <!-- виджет друзья-->
            <div class="widget-friend">
                <div class="heading-sm"> <a href="#" class="heading-sm_a-r">Все друзья 3</a>Мои друзья</div>
                <ul class="ava-list">
                    <li class="ava-list_li">
                        <!-- ava--><a href="#" class="ava ava__middle"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a>
                    </li>
                    <li class="ava-list_li">
                        <!-- ava--><a href="#" class="ava ava__middle"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/189385/74c3062ab78a806abc8d3a3e8990bf0e.jpg" class="ava_img"></a>
                    </li>
                    <li class="ava-list_li">
                        <!-- ava--><a href="#" class="ava ava__middle"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a>
                    </li>
                    <li class="ava-list_li">
                        <!-- ava--><a href="#" class="ava ava__middle"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/189385/74c3062ab78a806abc8d3a3e8990bf0e.jpg" class="ava_img"></a>
                    </li>
                    <li class="ava-list_li">
                        <!-- ava--><a href="#" class="ava ava__middle"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a>
                    </li>
                    <li class="ava-list_li">
                        <!-- ava--><a href="#" class="ava ava__middle"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/189385/74c3062ab78a806abc8d3a3e8990bf0e.jpg" class="ava_img"></a>
                    </li>
                    <li class="ava-list_li">
                        <!-- ava--><a href="#" class="ava ava__middle"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a>
                    </li>
                </ul>
            </div>
            <!-- /виджет друзья-->
            <!-- виджет клубы-->
            <div class="widget-club">
                <div class="heading-sm">Мои клубы</div>
                <ul class="widget-club_ul clearfix">
                    <li class="widget-club_li"><a href="#" class="i-club i-club__list-s i-club__collection-3">
                            <div class="ico-club ico-club__7"></div></a></li>
                    <li class="widget-club_li"><a href="#" class="i-club i-club__list-s i-club__collection-6">
                            <div class="ico-club ico-club__20"></div></a></li>
                    <li class="widget-club_li"><a href="#" class="i-club i-club__list-s i-club__collection-2">
                            <div class="ico-club ico-club__5"></div></a></li>
                    <li class="widget-club_li"><a href="#" class="i-club i-club__list-s i-club__collection-1">
                            <div class="ico-club ico-club__15"></div></a></li>
                </ul>
            </div>
            <!-- /виджет клубы-->

        </aside>
    </div>
</div>