<?php
$this->widget('application.widgets.yandexShareWidget.ShareWidget', array('model' => $this->post->socialObject));
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
        <?php if (in_array($this->post->originService, array('oldCommunity', 'advPost'))): ?>
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
                    <?php if ($this->user->specInfo !== null): ?>
                        <div class="b-article_authorpos"><?=$this->user->specInfo['title']?></div>
                    <?php endif; ?>
                </div>
                <div class="icons-meta"><a href="<?=$this->post->commentsUrl?>" class="icons-meta_comment"><span class="icons-meta_tx"><?=$comments->count?></span></a>
                    <div class="icons-meta_view"><span class="icons-meta_tx"><?=Yii::app()->getModule('analytics')->visitsManager->getVisits()?></span></div>
                </div>
            </div>
            <?php
            if (!$this->post->templateObject->getAttr('hideTitle', false)) {
                ?>
                <h1 class="b-article_t"><?= $this->post->title ?></h1>
                <?php
            }
            ?>
            <? if ($this->post->templateObject->getAttr('extraLikes', false)): ?>
                <div class="b-article_header-likes">
                    <share-buttons params="url: '<?=$this->post->url?>'"></share-buttons>
                </div>
            <?php endif; ?>
            <?php
            if (Yii::app()->user->checkAccess('moderator')) {
                ?>
                <redactor-panel params="entity: '<?= $this->post->originService == 'oldBlog' ? 'BlogContent' : $this->post->originEntity ?>', entityId: <?= $this->post->originEntityId ?>"></redactor-panel>
                <?php
            }
            ?>
            <div class="b-article_in clearfix">
                <?php if ($geo = $this->post->templateObject->getAttr('geo', false)) { ?>
                    <geo-morning params='<?= CJSON::encode($geo) ?>'>
                        <div class="b-article_in-where">
                            <span class="b-article_in-where__text">Где:</span>
                            <a target="_blank" href="http://maps.google.com/maps?q=<?= $geo['location'] ?>&hl=ru">
                                <img src="<?= $geo['locationImage'] ?>" alt="<?= $geo['location'] ?>">
                            </a>
                        </div>
                    </geo-morning>
                <?php } ?>
                <?php if ($this->post->templateObject->getAttr('noWysiwyg', false)) { ?>
                    <?= $this->post->html ?>
                <?php } else { ?>
                    <div class="wysiwyg-content clearfix"><?= $this->post->html ?></div>
                <?php } ?>
                <?php
                if (\Yii::app()->user->checkAccess('managePost', array('entity' => $this->post))) {
                    $this->widget('site\frontend\modules\posts\widgets\PostSettingsWidget', array('model' => $this->post, 'manageInfo' => $this->post->originManageInfoObject->toJSON()));
                }
                ?>
                <div class="like-control-hold">
                    <div class="like-control like-control__line">
                    </div>
                </div>
                <?php $this->widget('application.widgets.yandexShareWidget.ShareButtonsWidget', array('url' => $this->post->url)); ?>

                <?php $this->renderPartial('site.frontend.modules.posts.views.post._lr', array('left' => $this->leftPost, 'right' => $this->rightPost)); ?>

                <!-- Реклама яндекса-->
                <?php $this->renderPartial('//banners/_post_footer', array('data' => $this->post)); ?>

                <? if (! $this->post->templateObject->getAttr('hideRelap', false)): ?>
                <script id="iAsL_zX0O8E7vb29">if (window.relap) window.relap.ar('iAsL_zX0O8E7vb29');</script>
                <?php endif; ?>
            </div>
        </div>
    </article>
    <!-- /b-article-->
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
        </div>
    </section>
    <!-- /comments-->
    <?php
    if (false && $this->post->templateObject->getAttr('type', false) == 'question') {
        // Виджет "задать вопрос"
        $this->widget('site.frontend.modules.community.widgets.CommunityQuestionWidget', array('forumId' => $this->forum->id));
    }
    ?>

    <?php if (Yii::app()->user->checkAccess('moderator')): ?>
    <next-post params='post: <?=CJSON::encode($this->post->toJSON())?>'></next-post>
    <?php endif; ?>
</div>
<!-- /Основная колонка-->
<!--/////-->
