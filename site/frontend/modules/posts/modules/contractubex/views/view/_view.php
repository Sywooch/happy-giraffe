<?php
$this->widget('application.widgets.yandexShareWidget.ShareWidget', array('model' => $this->post->socialObject));
Yii::app()->clientScript->registerAMD('kow', array('kow'));
$comments = $this->createWidget('site\frontend\modules\comments\widgets\CommentWidget', array('model' => array(
    /** @todo Исправить класс при конвертации */
    'entity' => $this->post->originService == 'oldBlog' ? 'BlogContent' : $this->post->originEntity,
    'entity_id' => $this->post->originEntityId,
)));

if ($this->post->originService == 'oldBlog') {
    $entity = 'BlogContent';
} elseif (array_key_exists($this->post->originEntity, \site\frontend\modules\posts\models\Content::$entityAliases)) {
    $entity = addslashes(\site\frontend\modules\posts\models\Content::$entityAliases[$this->post->originEntity]);
} else {
    $entity = $this->post->originEntity;
}
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
                    <a href="<?= $this->user->profileUrl ?>" class="ava ava__female ava__middle-sm"><span class="ico-status ico-status__online"></span><img alt="" src="<?= $this->user->avatarUrl ?>" class="ava_img"></a><a href="<?= $this->user->profileUrl ?>" class="b-article_author"><?= $this->user->fullName ?></a>
                    <?= HHtml::timeTag($this->post, array('class' => 'tx-date'), null); ?>
                    <?php if ($this->user->specInfo !== null): ?>
                        <div class="b-article_authorpos"><?=$this->user->specInfo['title']?></div>
                    <?php endif; ?>
                </div>
                <div class="icons-meta"><a href="<?=$this->post->commentsUrl?>" class="icons-meta_comment"><span class="icons-meta_tx"><?=$comments->count?></span></a>
                    <div class="icons-meta_view"><span class="icons-meta_tx"><?=Yii::app()->getModule('analytics')->visitsManager->getVisits()?></span></div>
                </div>
                <?php if (! in_array($this->post->authorId, \site\frontend\modules\posts\modules\contractubex\components\ContractubexHelper::getAuthorsIds())): ?>
                <div class="promo-banner-small clearfix">
                    <div class="promo-banner-small_logo"></div>
                    <h2 class="promo-banner-small_text">А как Вы боретесь со шрамами?</h2>
                </div>
                <?php endif; ?>

            </div>
            <?php
            if (!$this->post->templateObject->getAttr('hideTitle', false)) {
                ?>
                <h1 class="b-article_t"><?= $this->post->title ?></h1>
            <?php
            }
            ?>
            <?php
            if (Yii::app()->user->checkAccess('moderator')) {
                ?>
                <redactor-panel params="entity: '<?= $entity ?>', entityId: <?= $this->post->originEntityId ?>"></redactor-panel>
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

                <?php $this->renderPartial('site.frontend.modules.posts.views.post._lr', array('left' => $this->leftPost, 'right' => $this->rightPost)); ?>
            </div>
        </div>
    </article>
    <!-- /b-article-->
    <?php //$this->renderPartial('//banners/_article_banner', compact('data')); ?>

    <!-- Put this div tag to the place, where the Comments block will be -->
    <div id="vk_comments"></div>
    <script type="text/javascript">
        require(['https://vk.com/js/api/openapi.js?127'], function() {
            VK.init({apiId: 2855330, onlyWidgets: true});
            VK.Widgets.Comments("vk_comments", {limit: 10, attach: "*"});
        });
    </script>

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
</div>
<!-- /Основная колонка-->
<!--/////-->
