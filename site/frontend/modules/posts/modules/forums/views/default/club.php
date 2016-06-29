<?php
/**
 * @var site\frontend\modules\posts\modules\forums\controllers\DefaultController $this
 * @var CommunityClub $club
 * @var string $feedTab
 * @var null|Community $feedForum
 */
$this->pageTitle = $club->title;
$breadcrumbs = [
    'Главная' => ['/site/index'],
    'Форумы' => ['/posts/forums/default/club', 'club' => $club->slug],
    $club->title,
];

/** @var \site\frontend\modules\posts\modules\forums\widgets\feed\FeedWidget $feedWidget */
$feedWidget = $this->createWidget('site\frontend\modules\posts\modules\forums\widgets\feed\FeedWidget', [
    'club' => $club,
    'forum' => $feedForum,
    'tab' => $feedTab,
]);
?>

<div class="forum-page">
    <div class="b-top-block-forum">
        <div class="b-breadcrumbs">
            <?php $this->widget('zii.widgets.CBreadcrumbs', [
                'links' => $breadcrumbs,
                'tagName' => 'ul',
                'homeLink' => false,
                'separator' => '',
                'activeLinkTemplate' => '<li><a href="{url}">{label}</a></li>',
                'inactiveLinkTemplate' => '<li>{label}</li>',
            ]); ?>
        </div>
        <div class="b-theme-title">
            <div class="b-theme-title-wrapper ico-club__<?=$club->id?>"></div>
            <h1><?=$club->title?></h1>
            <p><?=$club->description?></p><a href="#" class="start mobile"> </a>
        </div>
        <ul class="b-theme-title-more">
            <li class="theme-title__item">
                <subscribe params="clubId: <?=$club->id?>, isSubscribed: <?=UserClubSubscription::subscribed(Yii::app()->user->id, $club->id)?>"></subscribe>
            </li>
            <li class="theme-title__item"><span class="theme-title__img users"></span><span class="theme-title__descr"><?=\site\frontend\modules\community\helpers\StatsHelper::getSubscribers($club->id)?></span>участники</li>
            <li class="theme-title__item"><span class="theme-title__img messages"></span><span class="theme-title__descr"><?=\site\frontend\modules\community\helpers\StatsHelper::getComments($club->id)?></span>сообщений</li>
        </ul>
    </div>
    <div class="tabs visible-md">
        <?php Yii::beginProfile('FeedWidget'); $feedWidget->getMenuWidget()->run(); Yii::endProfile('FeedWidget'); ?>

        <?php if ($feedWidget->getShowFilter()): ?>
        <div class="b-dropdown-cat b-dropdown-cat_position">
            <?=CHtml::dropDownList('feedForumId', Yii::app()->request->url, $feedWidget->getFilterItems(), [
                'class' => 'js-dropdown__select dropdown__select',
                'encode' => false,
                'onchange' => "js: console.log($(this).find(':selected').val())",
            ])?>
        </div>
        <?php endif; ?>
    </div>
    <div class="b-main_cont b-main_cont-mobile">
        <div class="b-main-wrapper">
            <?php $feedWidget->run(); ?>
            <aside class="b-main_col-sidebar visible-md">
                <div class="sidebar-widget__padding">
                    <div class="textalign-c">
                        <a class="btn btn-success btn-xl btn-question w-240 fancy-top" href="<?=$this->createUrl('/blog/default/form', [
                            'type' => CommunityContent::TYPE_POST,
                            'club_id' => $club->id,
                            'useAMD' => true,
                        ])?>">Добавить тему</a>
                    </div>
                    <div class="questions-categories">
                        <?php Yii::beginProfile('UsersTopWidget'); $this->widget('\site\frontend\modules\posts\modules\forums\widgets\usersTop\UsersTopWidget', [
                            'labels' => [
                                \site\frontend\modules\posts\models\Label::LABEL_FORUMS,
                            ],
                        ]); Yii::endProfile('UsersTopWidget'); ?>
                    </div>
                    <div class="margin-t30">
                        <?php Yii::beginProfile('HotPostsWidget'); $this->widget('site\frontend\modules\posts\modules\forums\widgets\hotPosts\HotPostsWidget', [
                            'labels' => [
                                \site\frontend\modules\posts\models\Label::LABEL_FORUMS,
                            ],
                            'allUrl' => $this->createUrl('/posts/forums/default/club', [
                                'club' => $club->slug,
                                'feedTab' => \site\frontend\modules\posts\modules\forums\widgets\feed\FeedWidget::TAB_HOT,
                            ]),
                        ]); Yii::endProfile('HotPostsWidget'); ?>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>