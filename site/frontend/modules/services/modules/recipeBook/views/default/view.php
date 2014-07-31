<?php
/**
 * @var RecipeBookRecipe $recipe
 */
?>

<div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
        <!--/////-->
        <!-- Основная колонка-->
        <div class="b-main_col-article">
            <!-- b-article-->
            <article class="b-article clearfix">
                <div class="b-article_cont clearfix">
                    <div class="b-article_header clearfix">
                        <div class="icons-meta"><a href="" class="icons-meta_comment"><span class="icons-meta_tx"><?=$recipe->commentsCount?></span></a>
                            <div class="icons-meta_view"><span class="icons-meta_tx"><?=PageView::model()->viewsByPath($recipe->getUrl())?></span></div>
                        </div>
                        <div class="float-l">
                            <?php $this->widget('Avatar', array('user' => $recipe->author)); ?>
                            <div class="b-article_author"><a href="<?=$recipe->author->getUrl()?>" class="a-light"><?=$recipe->author->getFullName()?></a></div>
                            <time pubdate="1957-10-04" class="tx-date">Сегодня 13:25</time>
                        </div>
                    </div>
                    <h1 class="b-article_t"><?=$recipe->title?></h1>
                    <div class="b-article_in clearfix">
                        <div class="wysiwyg-content clearfix">
                            <?=$recipe->purified->text?>
                        </div>
                        <div class="ingredients">
                            <h3 class="ingredients_t">Ингредиенты:</h3>
                            <ul class="ingredients_ul">
                                <?php foreach ($recipe->ingredients as $i): ?>
                                    <li class="ingredients_i"><?=$i->ingredient->title?> - <?=$i->display_value?> <?=$i->noun?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="b-tags"><a href="" class="b-tags_tag">Болезни кровообращения</a><a href="" class="b-tags_tag">Лимфаденит</a></div>
                    </div>
                    <div class="textalign-c visible-md-block">
                        <div class="like-control like-control__line">
                            <div class="like-control_hold"><a href="" title="Нравится" class="like-control_i like-control_i__like powertip">
                                    <div class="like-control_t">Мне нравится!</div>
                                    <div class="ico-action-hg ico-action-hg__like"></div>
                                    <div class="like-control_tx">865</div></a></div>
                            <div class="like-control_hold"><a href="" title="В избранное" class="like-control_i like-control_i__idea powertip">
                                    <div class="like-control_t">В закладки</div>
                                    <div class="ico-action-hg ico-action-hg__favorite"></div>
                                    <div class="like-control_tx">863455</div></a></div>
                        </div>
                    </div>
                    <div class="custom-likes">
                        <div class="custom-likes_slogan">Поделитесь с друзьями!</div>
                        <div class="custom-likes_in">
                            <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
                            <div data-yasharel10n="ru" data-yasharequickservices="vkontakte,facebook,twitter,odnoklassniki,moimir" data-yasharetheme="counter" data-yasharetype="small" class="yashare-auto-init"></div>
                        </div>
                    </div>
                </div>
            </article>
            <!-- /b-article-->

            <?php if ($recipe->getPrev() !== null || $recipe->getNext() !== null): ?>
                <table ellpadding="0" cellspacing="0" class="article-nearby clearfix">
                    <tr>
                        <?php if ($recipe->getPrev() !== null): ?>
                            <td><a href="<?=$recipe->getPrev()->getUrl()?>" class="article-nearby_a article-nearby_a__l"><span class="article-nearby_tx"><?=$recipe->getPrev()->title?></span></a></td>
                        <?php endif; ?>
                        <?php if ($recipe->getNext() !== null): ?>
                            <td><a href="<?=$recipe->getNext()->getUrl()?>" class="article-nearby_a article-nearby_a__r"><span class="article-nearby_tx"><?=$recipe->getNext()->title?></span></a></td>
                        <?php endif; ?>
                    </tr>
                </table>
            <?php endif; ?>
            <div class="adv-yandex"><a href="" target="_blank"><img src="/lite/images/example/yandex-w600.jpg" alt=""></a></div>
            <!-- comments-->
            <section class="comments comments__buble">
            <div class="comments-menu">
                <ul data-tabs="tabs" class="comments-menu_ul">
                    <li class="comments-menu_li active"><a href="#commentsList" data-toggle="tab" class="comments-menu_a comments-menu_a__comments">Комментарии 68 </a></li>
                    <li class="comments-menu_li"><a href="#likesList" data-toggle="tab" class="comments-menu_a comments-menu_a__likes">Нравится 865</a></li>
                    <li class="comments-menu_li"><a href="#favoritesList" data-toggle="tab" class="comments-menu_a comments-menu_a__favorites">Закладки 865</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div id="commentsList" class="comments_hold tab-pane active">
                    <div class="comment-add">
                        <div class="comment-add_hold"> Комментировать от
                            <div class="ico-social-hold"><a href="" class="ico-social ico-social__odnoklassniki"></a><a href="" class="ico-social ico-social__vkontakte"></a></div> или <a class="comment-add_a">Войти</a>
                        </div>
                        <div class="comment-add_editor display-n"></div>
                    </div>
                    <ul class="comments_ul">
                        <!--
                        варианты цветов комментов. В такой последовательности
                        .comments_li__lilac
                        .comments_li__yellow
                        .comments_li__red
                        .comments_li__blue
                        .comments_li__green
                        -->
                        <li class="comments_li comments_li__lilac clearfix">
                            <div class="comments_i">
                                <div class="comments_ava">
                                    <!-- Аватарки размером 40*40-->
                                    <!-- ava--><a href="" class="ava ava__middle ava__small-sm-mid"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/189385/74c3062ab78a806abc8d3a3e8990bf0e.jpg" class="ava_img"></a>
                                </div>
                                <div class="comments_frame">
                                    <div class="comments_header"><a href="" rel="author" class="a-light comments_author"> Иванна Хлебникова</a>
                                        <time datetime="2012-12-23" class="tx-date">2 минуты назад</time>
                                    </div>
                                    <div class="comments_cont">
                                        <div class="wysiwyg-content">
                                            <p> Ну не все. Я видео скидыавала Лере Догузовой про матрешек вот это более правдивое представление.  Неотесанное быдло которое не умеет себя вести и это не Россия а и Украина тоже! </p>
                                            <!-- одно фото в блок (ссылку)--><a href="" class="comments_cont-img-w">
                                                <!-- размеры превью максимум 400*400 пк--><img alt="" src="/images/example/w220-h309-1.jpg"></a>
                                            <p>Меняя название трека в альбоме он автоматически производит поиск по сайту и подцепляет естественно студийные версии песен вместо нужных.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <ul class="comments_ul">
                                <!-- комментарий вложенный-->
                                <li class="comments_li comments_li__lilac clearfix">
                                    <div class="comments_i">
                                        <div class="comments_ava">
                                            <!-- Аватарки размером 40*40-->
                                            <!-- ava--><a href="" class="ava ava__middle ava__small-sm-mid"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/189385/74c3062ab78a806abc8d3a3e8990bf0e.jpg" class="ava_img"></a>
                                        </div>
                                        <div class="comments_frame">
                                            <div class="comments_header"><a href="" rel="author" class="a-light comments_author"> Иванна Хлебникова</a>
                                                <time datetime="2012-12-23" class="tx-date">2 минуты назад</time>
                                            </div>
                                            <div class="comments_cont">
                                                <div class="wysiwyg-content">
                                                    <p><a href="" class="comments_ansver-for">Ольга Максимова &nbsp; </a>Меняя название трека в альбоме он автоматически производит поиск по сайту и подцепляет естественно студийные версии песен вместо нужных.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <!-- /комментарий вложенный-->
                                <!-- комментарий вложенный-->
                                <!-- Свой комментарий-->
                                <li class="comments_li comments_li__self comments_li__lilac clearfix">
                                    <div class="comments_i">
                                        <div class="comments_ava">
                                            <!-- Аватарки размером 40*40-->
                                            <!-- ava--><a href="" class="ava ava__middle ava__small-sm-mid"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a>
                                        </div>
                                        <div class="comments_frame">
                                            <header class="comments_header"><a href="" rel="author" class="a-light comments_author">Ангелина Богоявленская</a>
                                                <time datetime="2012-12-23" class="tx-date">23 декабря</time>
                                            </header>
                                            <div class="comments_cont">
                                                <div class="wysiwyg-content">
                                                    <p>
                                                        <!-- Если аккаунт удален, меняем а на span что б не было 404 ошибок.--><span class="comments_ansver-for">Ольга Максимова &nbsp; </span>Свой комментарий. Меняя название трека в альбоме он автоматически производит поиск по сайту и подцепляет естественно студийные версии песен вместо нужных.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <!-- /комментарий вложенный-->
                            </ul>
                        </li>
                        <!-- / комментарий  -->
                        <!-- комментарий     -->
                        <li class="comments_li comments_li__red clearfix">
                            <div class="comments_i">
                                <div class="comments_ava">
                                    <!-- Аватарки размером 40*40-->
                                    <!-- ava--><a href="" class="ava ava__middle ava__small-sm-mid"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a>
                                </div>
                                <div class="comments_frame">
                                    <div class="comments_header"><a href="" rel="author" class="a-light comments_author"> Иванна Хлебникова</a>
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
                    <div class="article-users visible-md-block">
                        <div class="article-users_row"><a class="article-users_count">
                                <div class="ico-action-hg ico-action-hg__like"></div>
                                <div class="article-users_count-tx">865</div></a>
                            <div class="ava-list">
                                <ul class="ava-list_ul clearfix">
                                    <li class="ava-list_li">
                                        <!-- ava--><a href="" class="ava ava__small"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a>
                                    </li>
                                    <li class="ava-list_li">
                                        <!-- ava--><a href="" class="ava ava__small"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/189385/74c3062ab78a806abc8d3a3e8990bf0e.jpg" class="ava_img"></a>
                                    </li>
                                    <li class="ava-list_li">
                                        <!-- ava--><a href="" class="ava ava__small"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a>
                                    </li>
                                    <li class="ava-list_li">
                                        <!-- ava--><a href="" class="ava ava__small"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a>
                                    </li>
                                    <li class="ava-list_li">
                                        <!-- ava--><a href="" class="ava ava__small"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/189385/74c3062ab78a806abc8d3a3e8990bf0e.jpg" class="ava_img"></a>
                                    </li>
                                    <li class="ava-list_li">
                                        <!-- ava--><a href="" class="ava ava__small"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a>
                                    </li>
                                    <li class="ava-list_li">
                                        <!-- ava--><a href="" class="ava ava__small"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/189385/74c3062ab78a806abc8d3a3e8990bf0e.jpg" class="ava_img"></a>
                                    </li>
                                    <li class="ava-list_li">
                                        <!-- ava--><a href="" class="ava ava__small"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/189385/74c3062ab78a806abc8d3a3e8990bf0e.jpg" class="ava_img"></a>
                                    </li>
                                    <li class="ava-list_li">
                                        <!-- ava--><a href="" class="ava ava__small"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a>
                                    </li>
                                    <li class="ava-list_li">
                                        <!-- ava--><a href="" class="ava ava__small"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/189385/74c3062ab78a806abc8d3a3e8990bf0e.jpg" class="ava_img"></a>
                                    </li>
                                </ul>
                            </div><a class="a-light">Смотреть все</a>
                        </div>
                        <div class="article-users_row"><a class="article-users_count">
                                <div class="ico-action-hg ico-action-hg__favorite"></div>
                                <div class="article-users_count-tx">5</div></a>
                            <div class="ava-list">
                                <ul class="ava-list_ul clearfix">
                                    <li class="ava-list_li">
                                        <!-- ava--><a href="" class="ava ava__small"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a>
                                    </li>
                                    <li class="ava-list_li">
                                        <!-- ava--><a href="" class="ava ava__small"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/189385/74c3062ab78a806abc8d3a3e8990bf0e.jpg" class="ava_img"></a>
                                    </li>
                                    <li class="ava-list_li">
                                        <!-- ava--><a href="" class="ava ava__small"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a>
                                    </li>
                                    <li class="ava-list_li">
                                        <!-- ava--><a href="" class="ava ava__small"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a>
                                    </li>
                                    <li class="ava-list_li">
                                        <!-- ava--><a href="" class="ava ava__small"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/189385/74c3062ab78a806abc8d3a3e8990bf0e.jpg" class="ava_img"></a>
                                    </li>
                                </ul>
                            </div>
                            <!-- a.a-light Смотреть все-->
                        </div>
                    </div>
                </div>
                <div id="likesList" class="comments_hold tab-pane">
                    <div class="list-subsribe-users">
                        <ul class="list-subsribe-users_ul">
                            <li class="list-subsribe-users_li">
                                <!-- ava--><a href="" class="ava ava__middle"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a class="a-light">Ангелина Богоявленская</a>
                                <time datetime="1957-10-04" class="tx-date">Сегодня 13:25</time><a class="btn btn-secondary btn-sl">Читаю</a>
                            </li>
                            <li class="list-subsribe-users_li">
                                <!-- ava--><a href="" class="ava ava__middle"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a class="a-light">Ангелина Богоявленская</a>
                                <time datetime="1957-10-04" class="tx-date">Сегодня 13:25</time><a class="btn btn-success btn-sl"><span class="ico-plus"></span>Подписаться</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div id="favoritesList" class="comments_hold tab-pane">
                    <div class="list-subsribe-users">
                        <ul class="list-subsribe-users_ul">
                            <li class="list-subsribe-users_li">
                                <!-- ava--><a href="" class="ava ava__middle"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a class="a-light">Ангелина Богоявленская</a>
                                <time datetime="1957-10-04" class="tx-date">Сегодня 13:25</time><a class="btn btn-success btn-sl"><span class="ico-plus"></span>Подписаться</a>
                            </li>
                            <li class="list-subsribe-users_li">
                                <!-- ava--><a href="" class="ava ava__middle"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a class="a-light">Ангелина Богоявленская</a>
                                <time datetime="1957-10-04" class="tx-date">Сегодня 13:25</time><a class="btn btn-secondary btn-sl">Читаю</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            </section>
            <!-- /comments-->
        </div>
        <!-- /Основная колонка-->
    </div>
</div>