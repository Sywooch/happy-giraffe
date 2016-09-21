<?php
Yii::app()->clientScript->registerAMD('BlogRecordSettings', array('kow'));
/** @todo перенести обработку $this->post->metaObject в контроллер */
$this->pageTitle = $this->post->title;
$this->metaDescription = $this->post->metaObject->description;
$this->metaNoindex = $this->post->isNoindex;
Yii::app()->clientScript->registerAMD('kow', array('kow'));
$comments = $this->createWidget('site\frontend\modules\comments\widgets\CommentWidget', array('model' => array(
        /** @todo Исправить класс при конвертации */
        'entity' => $this->post->originService == 'oldBlog' ? 'BlogContent' : $this->post->originEntity,
        'entity_id' => $this->post->originEntityId,
        )));
$this->breadcrumbs = array(
    '<span class="ava ava__small">' . CHtml::image($this->user->avatarUrl, $this->user->fullName, array('class' => 'ava_img')) . "</span>" => $this->user->profileUrl,
    'Блог' => Yii::app()->createUrl('/blog/default/index', array('user_id' => $this->user->id)),
    $this->post->title,
);
$thumb = \Yii::app()->thumbs->getThumb($this->attach->photoModel, 'postCollectionCover');
?>
<div class="b-main_col-article">
    <?php if (Yii::app()->user->checkAccess('toggleAnounces')): ?>
        <?php if ($this->post->originService == 'oldCommunity'): ?>
            <?php
            $this->widget('site\frontend\modules\ads\widgets\OnOffWidget', array(
                'model' => $this->post,
                'line' => 'bigPost',
                'preset' => 'bigPost',
                'title' => 'Большой пост',
            ));
            ?>
            <?php
            $this->widget('site\frontend\modules\ads\widgets\OnOffWidget', array(
                'model' => $this->post,
                'line' => 'smallPost',
                'preset' => 'smallPost',
                'title' => 'Маленький пост',
            ));
            ?>
        <?php endif; ?>
    <?php endif; ?>
    <!-- Статья с текстом-->
    <!-- b-article-->
    <article class="b-article b-article__single clearfix b-article__lite">
        <div class="b-article_cont clearfix">
            <div class="b-article_cont-tale"></div>
            <div class="b-article_header clearfix">
                <div class="float-l">
                    <a href="<?= $this->user->profileUrl ?>" class="ava ava__female ava__middle-sm"><span class="ico-status ico-status__online"></span><img alt="" src="<?= $this->user->avatarUrl ?>" class="ava_img"></a><a href="<?= $this->user->profileUrl ?>" class="b-article_author"><?= $this->user->fullName ?></a>
                    <?= HHtml::timeTag($this->post, array('class' => 'tx-date'), null); ?>
                </div>
                <div class="icons-meta"><a href="<?= $this->post->commentsUrl ?>" class="icons-meta_comment"><span class="icons-meta_tx"><?= $comments->count ?></span></a>
                    <div class="icons-meta_view"><span class="icons-meta_tx"><?= $this->post->views ?></span></div>
                </div>
            </div>
            <h1 class="b-article_t"><?= $this->post->title ?></h1>
            <?php
            if (Yii::app()->user->checkAccess('moderator')) {
                ?>
                <redactor-panel params="entity: '<?= $this->post->originService == 'oldBlog' ? 'BlogContent' : $this->post->originEntity ?>', entityId: <?= $this->post->originEntityId ?>"></redactor-panel>
                <?php
            }
            ?>
            <div class="b-article_in clearfix">
                <div class="wysiwyg-content clearfix">
                    <post-photo-view params="id: <?= $this->post->originEntityId ?>, photo: <?= $this->attach->id ?>"></post-photo-view>
                    <?php
                    /* echo \CHtml::tag('photo-photopost', array(
                      'params' =>
                      'id: ' . (int) $this->collection->id . ', ' .
                      'attachCount: ' . (int) $this->collection->attachesCount . ', ' .
                      'userId: ' . (int) $this->post->authorId . ', ' .
                      'coverId: ' . $this->collection->cover['id'],
                      ), '') */
                    ?>
                </div>
            </div>
            <?php
            if (\Yii::app()->user->checkAccess('managePost', array('entity' => $this->post))) {
                $this->widget('site\frontend\modules\posts\widgets\PostSettingsWidget', array('model' => $this->post, 'manageInfo' => $this->post->originManageInfoObject->toJSON()));
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
            <div class="custom-likes">
                <div class="custom-likes_slogan">Поделитесь с друзьями!</div>
                <div class="custom-likes_in">
                    <share-buttons params="url: '<?=$this->post->url?>'"></share-buttons>
                </div>
            </div>
            <?php $this->widget('application.widgets.yandexShareWidget.ShareWidget', array('model' => $this->post->socialObject)); ?>
            <!-- Реклама яндекса-->
            <?php $this->renderPartial('//banners/_post_footer', array('data' => $this->post)); ?>
        </div>
    </article>
    <!-- /b-article-->
    <?php $this->renderPartial('site.frontend.modules.posts.views.post._lr', array('left' => $this->leftPost, 'right' => $this->rightPost)); ?>
    <?php $this->renderPartial('//banners/_article_banner', array('data' => $this->post)); ?>
    <!-- comments-->
    <section class="comments comments__buble">
        <div class="comments-menu">
            <ul data-tabs="tabs" class="comments-menu_ul">
                <li class="comments-menu_li active"><a href="#commentsList" data-toggle="tab" class="comments-menu_a comments-menu_a__comments">Комментарии <?= $comments->count ?> </a></li>
            </ul>
        </div>
        <div class="tab-content">
            <?php $comments->run(); ?>
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
