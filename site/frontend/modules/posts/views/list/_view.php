<?php
$cs = Yii::app()->clientScript;
$cs->registerAMD('BlogRecordSettings', array('kow'));
?>
<article class="b-article b-article__list clearfix">
    <div class="b-article_cont clearfix">
        <div class="b-article_header clearfix">
            <div class="float-l">
                <!-- ava--><a href="<?= $data->user->profileUrl ?>" class="ava ava__female ava__small-xxs ava__middle-xs ava__middle-sm-mid "><span class="ico-status ico-status__online"></span><img alt="<?= $data->user->fullName ?>" src="<?= $data->user->avatarUrl ?>" class="ava_img"></a><a href="<?= $data->user->profileUrl ?>" class="b-article_author"><?= $data->user->fullName ?></a>
                <?= HHtml::timeTag($data, array('class' => 'tx-date'), null) ?>
            </div>
        </div>
        <div class="b-article_t-list"><a href="<?= $data->parsedUrl ?>" class="b-article_t-a"><?= $data->title ?></a></div>
        <div class="b-article_in clearfix"><div class="wysiwyg-content clearfix"><?= $data->preview ?></div></div>
        <!-- comments-->
        <? /* <section class="comments">
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
          </section> */ ?>
        <!-- /comments-->
        <div class="b-article_like clearfix">

            <?php
            if ($data->authorId == Yii::app()->user->id) {
                ?>
                <article-settings params="articleId: <?=$data->originEntityId?>, editUrl: <?= Yii::app()->createUrl('/blog/tmp/index', array('id' => $data->originEntityId)) ?>"></article-settings>
<!--                <div class="article-settings">-->
<!--                    <div class="article-settings_i"><a href="#" class="article-settings_a article-settings_a__settings powertip"></a></div>-->
<!--                    <div class="article-settings_hold display-b">-->
<!--                        <!--<div class="article-settings_i"><a href="#" class="article-settings_a article-settings_a__pin powertip"></a></div>-->-->
<!--                        <div class="article-settings_i"><a href="--><?//= Yii::app()->createUrl('/blog/tmp/index', array('id' => $data->originEntityId)) ?><!--" class="article-settings_a article-settings_a__edit powertip"></a></div>-->
<!--                        <div class="article-settings_i"><a href="#" class="article-settings_a article-settings_a__delete powertip"></a></div>-->
<!--                    </div>-->
<!--                </div>-->
            <?php
            }
            ?>
            <div class="article-also">
                <div class="article-also_row like-control-hold">
                    <!-- при маленьком размере в мобильном исчезают только лайки и избранное-->
                    <!--<div class="like-control like-control__small">
                    <div class="like-control_hold like-control_hold__comment"><a href="<?= $data->commentsUrl ?>" title="Комментировать" class="like-control_i powertip">
                            <div href="#" class="ico-action-hg ico-action-hg__comment"> </div>
                            <div class="like-control_tx">&nbsp;</div></a></div>
                    <div class="like-control_hold visible-md-inline-block"><a href="#" title="Нравится" onclick="openLoginPopup(event);
                            return false;" class="like-control_i powertip">
                            <div class="ico-action-hg ico-action-hg__like"></div>
                            <div class="like-control_tx">&nbsp;</div></a></div>
                    <div class="like-control_hold visible-md-inline-block"><a href="#" title="В избранное" onclick="openLoginPopup(event);
                            return false;" class="like-control_i powertip">
                            <div class="ico-action-hg ico-action-hg__favorite"></div>
                            <div class="like-control_tx">&nbsp;</div></a>
                    </div>
                </div>-->
                </div>

                <!--<div class="article-also_row">
                <div class="article-also_tx">Смотреть все <a href="<?= $data->commentsUrl ?>">комментарии</a>
                    <div class="visible-md-inline-block">,<a href="#"> нравится, </a></div>
                    <div class="visible-md-inline-block"><a href="#"> закладки </a></div>.
                </div>
            </div>-->
            </div>
        </div>

    </div>
</article>