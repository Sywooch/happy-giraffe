<?php
/**
 * @var PhotoController $this
 * @var site\frontend\modules\photo\models\PhotoAttach $attach
 * @var site\frontend\modules\photo\models\PhotoAlbum $album
 * @var int $userId
 * @var ClientScript $cs
 */
$photo = $attach->photo;
$this->breadcrumbs += array(
    'Фото' => array('/photo/default/index', 'userId' => $userId),
    $album->title => $album->getUrl(),
    $attach->getTitle(),
);
$commentsWidget = $this->createWidget('site\frontend\modules\comments\widgets\CommentWidget', array('model' => $photo));
$cs = Yii::app()->clientScript;
$cs->registerAMD('photo-single', array('kow'));
?>

<div class="b-main">
    <div class="b-main_cont">
        <div class="b-main_col-hold clearfix">
            <div class="b-main_col-article">
                <!-- b-article-->
                <div class="b-article clearfix">
                    <div class="b-article_header clearfix">
                        <div class="icons-meta"><a href="" class="icons-meta_comment"><span class="icons-meta_tx"><?=$commentsWidget->count?></span></a>
                            <div class="icons-meta_view"><span class="icons-meta_tx"><?=$this->getViews()?></span></div>
                        </div>
                        <div class="float-l">
                            <?php $this->widget('Avatar', array('user' => $photo->author)); ?>
                            <div class="b-article_author"><a href="<?=$photo->author->getUrl()?>" class="a-light"><?=$photo->author->getFullName()?></a></div>

                        </div>
                    </div>
                    <h1 class="b-article_t"><?=$attach->getTitle()?></h1>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="b-main_cont b-main_cont__wide">
    <photo-single params='userId: <?= $userId ?>, attach: <?= \HJSON::encode($attach) ?>, attachPrev: <?= \HJSON::encode($attach) ?>, attachNext: <?= \HJSON::encode($attach) ?>, collectionId: <?= $album->getPhotoCollection()->id ?>'></photo-single>
</div>

<div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
        <div class="b-main_col-article">
        <!-- b-article-->
        <div class="b-article clearfix">
            <div class="wysiwyg-content">
                <p><?=$photo->description?></p>
            </div>
        </div>
        <!--<div class="textalign-c visible-md-block">
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
         /div>-->
        <?php $this->widget('application.widgets.yandexShareWidget.YandexShareWidget', array('model' => $photo, 'lite' => true)); ?>
        <!-- Реклама яндекса-->
        <?php $this->renderPartial('//banners/_direct_others'); ?>
        <!-- comments-->
        <section class="comments comments__buble">
            <div class="comments-menu">
                <ul data-tabs="tabs" class="comments-menu_ul">
                    <li class="comments-menu_li active"><a href="#commentsList" data-toggle="tab" class="comments-menu_a comments-menu_a__comments">Комментарии <?=$commentsWidget->count?> </a></li>
                    <!--<li class="comments-menu_li"><a href="#likesList" data-toggle="tab" class="comments-menu_a comments-menu_a__likes">Нравится 865</a></li>
                    <li class="comments-menu_li"><a href="#favoritesList" data-toggle="tab" class="comments-menu_a comments-menu_a__favorites">Закладки 865</a></li>-->
                </ul>
            </div>
            <div class="tab-content">
                <?php $commentsWidget->run(); ?>
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
    </div>
</div>