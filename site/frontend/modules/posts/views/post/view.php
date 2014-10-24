<?php
$this->breadcrumbs = array(
    'asdfdfas',
);
$comments = $this->createWidget('site\frontend\modules\comments\widgets\CommentWidget', array('model' => array(
        /** @todo Исправить класс при конвертации */
        'entity' => 'BlogContent', //$this->post->originEntity,
        'entity_id' => $this->post->originEntityId,
    )));
?>
<div class="b-main_col-hold clearfix">
    <!--/////-->
    <!-- Основная колонка-->
    <div class="b-main_col-article">
        <!-- Статья с текстом-->
        <!-- b-article-->
        <article class="b-article b-article__single clearfix b-article__lite">
            <div class="b-article_cont clearfix">
                <div class="b-article_cont-tale"></div>
                <div class="b-article_header clearfix">
                    <div class="float-l">
                        <a href="#" class="ava ava__female ava__small-xs ava__middle-sm"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a href="" class="b-article_author"><?= $this->user->fullName ?></a>
                        <?= HHtml::timeTag($this->post); ?>
                    </div>
                    <div class="icons-meta"><a href="" class="icons-meta_comment"><span class="icons-meta_tx"><?= $comments->count ?></span></a>
                        <div class="icons-meta_view"><span class="icons-meta_tx">305</span></div>
                    </div>
                </div>
                <h1 class="b-article_t"><?= $this->post->title ?></h1>
                <div class="b-article_in clearfix">
                    <div class="wysiwyg-content clearfix"><?= $this->post->html ?></div>
                    <div class="textalign-c visible-md-block">
                        <div class="like-control like-control__line">
                            <div class="like-control_hold"><a href="#" onclick="openLoginPopup(event)" title="Нравится" class="like-control_i like-control_i__like powertip">
                                    <div class="like-control_t">Мне нравится!</div>
                                    <div class="ico-action-hg ico-action-hg__like"></div>
                                    <div class="like-control_tx">через js</div></a></div>
                            <div class="like-control_hold"><a href="#" onclick="openLoginPopup(event)" title="В избранное" class="like-control_i like-control_i__idea powertip">
                                    <div class="like-control_t">В закладки</div>
                                    <div class="ico-action-hg ico-action-hg__favorite"></div>
                                    <div class="like-control_tx">через js</div></a>
                            </div>
                        </div>
                    </div>
                    <!-- Лайки от яндекса-->
                    <div class="custom-likes">
                        <div class="custom-likes_slogan">Поделитесь с друзьями!
                        </div>
                        <div class="custom-likes_in">
                            <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
                            <div data-yasharel10n="ru" data-yasharequickservices="vkontakte,facebook,twitter,odnoklassniki,moimir" data-yasharetheme="counter" class="yashare-auto-init"></div>
                        </div>
                    </div>
                    <!-- Лайки от яндекса-->
                    <!-- Реклама яндекса-->
                    <div class="adv-yandex"><a href="#" target="_blank"><img src="/lite/images/example/yandex-w600.jpg" alt=""></a></div>
                </div>
            </div>
        </article>
        <!-- /b-article-->
        <!-- стрелку листания записей можно расположить практически в любом месте по коду где удобней программисту -->
        <a href="#" class="post-arrow post-arrow__l">
            <div class="i-photo-arrow"></div>
            <div class="post-arrow_in-hold">
                <div class="post-arrow_in">
                    <div class="post-arrow_img-hold"><img src="/lite/images/example/w122-h85-1.jpg" alt="Ксения Бородина впервые в своей жизни сварила суп" class="post-arrow_img"></div>
                    <div class="post-arrow_t">Ксения Бородина впервые в своей жизни сварила суп</div>
                </div>
            </div>
        </a>
        <a href="#" class="post-arrow post-arrow__r">
            <div class="i-photo-arrow"></div>
            <div class="post-arrow_in-hold">
                <div class="post-arrow_in">
                    <div class="post-arrow_img-hold"><img src="/lite/images/example/w122-h85-1.jpg" alt="Ксения Бородина впервые в своей жизни сварила суп" class="post-arrow_img"></div>
                    <div class="post-arrow_t">Ксения Бородина впервые в своей жизни сварила суп</div>
                </div>
            </div>
        </a>
        <table class="article-nearby clearfix">
            <tr>
                <td><a href="#" class="article-nearby_a article-nearby_a__l"><span class="article-nearby_tx">Как приготовить Монастыпскую избу </span></a></td>
                <td><a href="#" class="article-nearby_a article-nearby_a__r"><span class="article-nearby_tx">Готовим  Торт Сметанник в домашних условиях</span></a></td>
            </tr>
        </table>
        <div class="adv-banner"><a href="#" target="_blank"><img alt="" src="/lite/images/example/w600-h400.jpg"></a></div>
        <!-- comments-->
        <section class="comments comments__buble">
            <div class="comments-menu">
                <ul data-tabs="tabs" class="comments-menu_ul">
                    <li class="comments-menu_li active"><a href="#commentsList" data-toggle="tab" class="comments-menu_a comments-menu_a__comments">Комментарии <?= $comments->count ?> </a></li>
                    <!--<li class="comments-menu_li"><a href="#likesList" data-toggle="tab" class="comments-menu_a comments-menu_a__likes">Нравится 865</a></li>
                    <li class="comments-menu_li"><a href="#favoritesList" data-toggle="tab" class="comments-menu_a comments-menu_a__favorites">Закладки 865</a></li>-->
                </ul>
            </div>
            <div class="tab-content">
                <?php $comments->run(); ?>
                <!--<div id="likesList" class="comments_hold tab-pane">
                    <div class="list-subsribe-users">
                        <ul class="list-subsribe-users_ul">
                            <li class="list-subsribe-users_li">
                                <a href="#" class="ava ava__middle"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a class="a-light">Ангелина Богоявленская</a>
                                <time datetime="1957-10-04" class="tx-date">Сегодня 13:25</time><a class="btn btn-secondary btn-sl">Читаю</a>
                            </li>
                            <li class="list-subsribe-users_li">
                                <a href="#" class="ava ava__middle"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a class="a-light">Ангелина Богоявленская</a>
                                <time datetime="1957-10-04" class="tx-date">Сегодня 13:25</time><a class="btn btn-success btn-sl"><span class="ico-plus"></span>Подписаться</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div id="favoritesList" class="comments_hold tab-pane">
                    <div class="list-subsribe-users">
                        <ul class="list-subsribe-users_ul">
                            <li class="list-subsribe-users_li">
                                <a href="#" class="ava ava__middle"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a class="a-light">Ангелина Богоявленская</a>
                                <time datetime="1957-10-04" class="tx-date">Сегодня 13:25</time><a class="btn btn-success btn-sl"><span class="ico-plus"></span>Подписаться</a>
                            </li>
                            <li class="list-subsribe-users_li">
                                <a href="#" class="ava ava__middle"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a class="a-light">Ангелина Богоявленская</a>
                                <time datetime="1957-10-04" class="tx-date">Сегодня 13:25</time><a class="btn btn-secondary btn-sl">Читаю</a>
                            </li>
                        </ul>
                    </div>
                </div>-->
            </div>
        </section>
        <!-- /comments-->
    </div>
    <!-- /Основная колонка-->
    <!--/////-->
    <!-- Сайд бар-->
    <!-- Содержимое загружaть отложено-->
    <aside class="b-main_col-sidebar visible-md">
        <?php /*
          <div class="adv-banner adv-banner__bd"><a href=""><img src="/lite/images/example/w240-h400.jpg" alt=""></a></div>
          <!-- Варианты цветов блока
          article-similar__green
          article-similar__blue
          article-similar__lilac
          article-similar__red
          article-similar__yellow
          -->
          <div class="article-similar article-similar__lilac">
          <div class="article-similar_row">
          <!-- ava--><a href="#" class="ava ava__small"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a href="" class="article-similar_author">Марина Правдин</a>
          </div>
          <div class="article-similar_row"><a href="" class="article-similar_t">Наши первые движения </a></div>
          <div class="article-similar_img-hold"><a href=""><img src="/lite/images/example/w240-h165.jpg" alt="" class="article-similar_img"></a></div>
          </div>
          <div class="article-similar article-similar__red">
          <div class="article-similar_row">
          <!-- ava--><a href="#" class="ava ava__small"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a href="" class="article-similar_author">Марина Правдинwerwerweryrtyrtyrtyrtyrtyа</a>
          </div>
          <div class="article-similar_row"><a href="" class="article-similar_t">Наши первые движения</a></div>
          <div class="article-similar_img-hold"><a href=""><img src="/lite/images/example/w240-h176.jpg" alt="" class="article-similar_img"></a></div>
          </div>
          <div class="article-similar article-similar__yellow">
          <div class="article-similar_row">
          <!-- ava--><a href="#" class="ava ava__small"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a href="" class="article-similar_author">Марина !!Красотуля!!</a>
          </div>
          <div class="article-similar_row"><a href="" class="article-similar_t">Наши первые движения по полу в окружении родителей</a></div>
          <div class="article-similar_img-hold"><a href=""><img src="/lite/images/example/w240-h165.jpg" alt="" class="article-similar_img"></a></div>
          </div>
          <div class="article-similar article-similar__blue">
          <div class="article-similar_row">
          <!-- ava--><a href="#" class="ava ava__small"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a href="" class="article-similar_author">Марина Правдина</a>
          </div>
          <div class="article-similar_row"><a href="" class="article-similar_t">Коррекция фигуры: убираем висячий дряблый живот</a></div>
          <div class="article-similar_img-hold"><a href=""><img src="/lite/images/example/w240-h183.jpg" alt="" class="article-similar_img"></a></div>
          </div>
          <div class="article-similar article-similar__green">
          <div class="article-similar_row">
          <!-- ava--><a href="#" class="ava ava__small"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a href="" class="article-similar_author">Марина Правдина</a>
          </div>
          <div class="article-similar_row"><a href="" class="article-similar_t">Обязательства мешают любовным отношениям</a></div>
          <div class="article-similar_img-hold"><a href=""><img src="/lite/images/example/w240-h165.jpg" alt="" class="article-similar_img"></a></div>
          </div> */ ?>
    </aside>
    <!-- Сайд бар-->
</div>