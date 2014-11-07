<?php
/** @todo перенести обработку $this->post->metaObject в контроллер */
$this->pageTitle = $this->post->title;
$this->metaDescription = $this->post->metaObject->description;
$this->breadcrumbs = array(
    '<span class="ava ava__small">' . CHtml::image($this->user->avatarUrl, $this->user->fullName, array('class' => 'ava_img')) . "</span>" => $this->user->profileUrl,
    'Блог' => Yii::app()->createUrl('/blog/default/index', array('user_id' => $this->user->id)),
    $this->post->title,
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
                        <a href="<?= $this->user->profileUrl ?>" class="ava ava__female ava__small-xs ava__middle-sm"><span class="ico-status ico-status__online"></span><img alt="" src="<?= $this->user->avatarUrl ?>" class="ava_img"></a><a href="<?= $this->user->profileUrl ?>" class="b-article_author"><?= $this->user->fullName ?></a>
                        <?= HHtml::timeTag($this->post, array('class' => 'tx-date'), null); ?>
                    </div>
                    <div class="icons-meta"><a href="<?= $this->post->commentsUrl ?>" class="icons-meta_comment"><span class="icons-meta_tx"><?= $comments->count ?></span></a>
                        <div class="icons-meta_view"><span class="icons-meta_tx"><?= PageView::model()->incViewsByPath($this->post->parsedUrl) ?></span></div>
                    </div>
                </div>
                <h1 class="b-article_t"><?= $this->post->title ?></h1>
                <div class="b-article_in clearfix">
                    <div class="wysiwyg-content clearfix"><?= $this->post->html ?></div>
                    <!--<div class="textalign-c visible-md-block">
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
                    </div>-->
                    <?php $this->widget('application.widgets.yandexShareWidget.YandexShareWidget', array('model' => $this->post->socialObject, 'lite' => true)); ?>
                    <!-- Реклама яндекса-->
                    <?php $this->renderPartial('//banners/_direct_others'); ?>
                </div>
            </div>
        </article>
        <!-- /b-article-->
        <?php $this->renderPartial('_lr', array('left' => $this->leftPost, 'right' => $this->rightPost)); ?>
        <?php $this->renderPartial('//banners/_article_banner', compact('data')); ?>
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
        <?php $this->beginWidget('AdsWidget', array('dummyTag' => 'adfox')); ?>
        <div class="banner">
            <!--AdFox START-->
            <!--giraffe-->
            <!--Площадка: Весёлый Жираф / * / *-->
            <!--Тип баннера: Безразмерный 240x400-->
            <!--Расположение: &lt;сайдбар&gt;-->
            <!-- ________________________AdFox Asynchronous code START__________________________ -->
            <script type="text/javascript">
                <!--
                if (typeof(pr) == 'undefined') { var pr = Math.floor(Math.random() * 1000000); }
                if (typeof(document.referrer) != 'undefined') {
                    if (typeof(afReferrer) == 'undefined') {
                        afReferrer = escape(document.referrer);
                    }
                } else {
                    afReferrer = '';
                }
                var addate = new Date();


                var dl = escape(document.location);
                var pr1 = Math.floor(Math.random() * 1000000);

                document.write('<div id="AdFox_banner_'+pr1+'"><\/div>');
                document.write('<div style="visibility:hidden; position:absolute;"><iframe id="AdFox_iframe_'+pr1+'" width=1 height=1 marginwidth=0 marginheight=0 scrolling=no frameborder=0><\/iframe><\/div>');

                AdFox_getCodeScript(1,pr1,'http://ads.adfox.ru/211012/prepareCode?pp=dey&amp;ps=bkqy&amp;p2=etcx&amp;pct=a&amp;plp=a&amp;pli=a&amp;pop=a&amp;pr=' + pr +'&amp;pt=b&amp;pd=' + addate.getDate() + '&amp;pw=' + addate.getDay() + '&amp;pv=' + addate.getHours() + '&amp;prr=' + afReferrer + '&amp;dl='+dl+'&amp;pr1='+pr1);
                // -->
            </script>
            <!-- _________________________AdFox Asynchronous code END___________________________ -->
        </div>
        <?php $this->endWidget(); ?>
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
        <?php $this->renderPartial('//banners/_sidebar'); ?>
    </aside>
    <!-- Сайд бар-->
</div>