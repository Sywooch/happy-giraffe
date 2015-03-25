<?php
Yii::app()->clientScript->registerAMD('kow', array('kow'));
$comments = $this->createWidget('site\frontend\modules\comments\widgets\CommentWidget', array('model' => array(
        /** @todo Исправить класс при конвертации */
        'entity' => $this->post->originService == 'oldBlog' ? 'BlogContent' : $this->post->originEntity,
        'entity_id' => $this->post->originEntityId,
        )));
?>
<!-- Основная колонка-->
<div class="b-main_col-article">
    <?php if (Yii::app()->user->checkAccess('toggleAnounces')): ?>
        <?php if ($this->post->originService == 'oldCommunity'): ?>
            <?php $this->widget('site\frontend\modules\ads\widgets\OnOffWidget', array(
                'model' => $this->post,
                'line' => 'bigPost',
                'preset' => 'bigPost',
                'title' => 'Большой пост',
            )); ?>
            <?php $this->widget('site\frontend\modules\ads\widgets\OnOffWidget', array(
                'model' => $this->post,
                'line' => 'smallPost',
                'preset' => 'smallPost',
                'title' => 'Маленький пост',
            )); ?>
        <?php endif; ?>
    <?php endif; ?>
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
                <div class="icons-meta"><a href="<?=$this->post->commentsUrl?>" class="icons-meta_comment"><span class="icons-meta_tx"><?=$comments->count?></span></a>
                    <div class="icons-meta_view"><span class="icons-meta_tx"><?=$this->post->views?></span></div>
                </div>
            </div>
            <?php
            if (!$this->post->templateObject->getAttr('hideTitle', false)) {
                ?>
                <h1 class="b-article_t"><?= $this->post->title ?></h1>
                <?php
            }
            if (Yii::app()->user->checkAccess('moderator')) {
                ?>
                <redactor-panel params="entity: '<?= $this->post->originService == 'oldBlog' ? 'BlogContent' : $this->post->originEntity ?>', entityId: <?= $this->post->originEntityId ?>"></redactor-panel>
                <?php
            }
            ?>
            <div class="b-article_in clearfix">
                <?php if ($this->post->templateObject->getAttr('noWysiwyg', false)) { ?>
                    <?= $this->post->html ?>
                <?php } else { ?>
                    <div class="wysiwyg-content clearfix"><?= $this->post->html ?></div>
                <?php } ?>
                <?php
                if (\Yii::app()->user->checkAccess('managePost', array('entity' => $this->post))) {
                    ?>
                    <article-settings params="articleId: <?= $this->post->originEntityId ?>, editUrl: '<?= Yii::app()->createUrl('/blog/tmp/index', array('id' => $this->post->originEntityId)) ?>'"></article-settings>
                <?php
                }
                ?>
                <div class="like-control-hold">
                    <div class="like-control like-control__line">
                        <!--<div class="like-control_hold"><a href="#" onclick="openLoginPopup(event)" title="Нравится" class="like-control_i like-control_i__like powertip">
                                <div class="like-control_t">Мне нравится!</div>
                                <div class="ico-action-hg ico-action-hg__like"></div>
                                <div class="like-control_tx">через js</div></a></div>
                        <div class="like-control_hold"><a href="#" onclick="openLoginPopup(event)" title="В избранное" class="like-control_i like-control_i__idea powertip">
                                <div class="like-control_t">В закладки</div>
                                <div class="ico-action-hg ico-action-hg__favorite"></div>
                                <div class="like-control_tx">через js</div></a>
                        </div>-->
                    </div>
                </div>
                <?php $this->widget('application.widgets.yandexShareWidget.YandexShareWidget', array('model' => $this->post->socialObject, 'lite' => true)); ?>
                <!-- Реклама яндекса-->
                <?php $this->renderPartial('//banners/_post_footer', array('data' => $this->post)); ?>
            </div>
        </div>
    </article>
    <!-- /b-article-->
    <?php $this->renderPartial('site.frontend.modules.posts.views.post._lr', array('left' => $this->leftPost, 'right' => $this->rightPost)); ?>
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
    <?php
    if (false && $this->post->templateObject->getAttr('type', false) == 'question') {
        // Виджет "задать вопрос"
        $this->widget('site.frontend.modules.community.widgets.CommunityQuestionWidget', array('forumId' => $this->forum->id));
    }
    ?>
</div>
<!-- /Основная колонка-->
<!--/////-->