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
            <div class="b-theme-title-img"></div>
            <h1><?=$club->title?></h1>
            <p><?=$club->description?></p><a href="#" class="start mobile"> </a>
        </div>
        <ul class="b-theme-title-more">
            <subscribe params="clubId: <?=$club->id?>, isSubscribed: <?=UserClubSubscription::subscribed(Yii::app()->user->id, $club->id)?>"></subscribe>
            <li class="users"><span><?=\site\frontend\modules\community\helpers\StatsHelper::getSubscribers($club->id)?></span>участники</li>
            <li class="messages"><span><?=\site\frontend\modules\community\helpers\StatsHelper::getComments($club->id)?></span>сообщений</li>
        </ul>
    </div>
    <div class="tabs visible-md">
        <?php $feedWidget->getMenuWidget()->run(); ?>
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
                        <?php if ($this->beginCache('Forums.OnlineUsersWidget', ['duration' => 300])) { $this->widget('\site\frontend\modules\posts\modules\forums\widgets\usersTop\UsersTopWidget', [
                            'labels' => [
                                \site\frontend\modules\posts\models\Label::LABEL_FORUMS,
                            ],
                        ]); $this->endCache(); } ?>
                    </div>
                    <div class="margin-t30">
                        <?php if ($this->beginCache('Forums.LastPostWidget', ['duration' => 300])) { $this->widget('site\frontend\modules\posts\modules\forums\widgets\hotPosts\HotPostsWidget', [
                            'labels' => [
                                \site\frontend\modules\posts\models\Label::LABEL_FORUMS,
                            ],
                            'allUrl' => $this->createUrl('/posts/forums/default/club', [
                                'club' => $club->slug,
                                'feedTab' => \site\frontend\modules\posts\modules\forums\widgets\feed\FeedWidget::TAB_HOT,
                            ]),
                        ]); $this->endCache(); } ?>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>

<?php if (false): ?>
<div class="forum-page">
    <div class="b-top-block-forum">
        <div class="b-breadcrumbs">
            <ul>
                <li><a href="#">Главная</a></li>
                <li><a href="#">Форумы</a></li>
                <li>Дети старше года</li>
            </ul>
        </div>
        <div class="b-theme-title">
            <div class="b-theme-title-img"></div>
            <h1><?=$club->title?></h1>
            <p><?=$club->description?></p><a href="#" class="start mobile"> </a>
        </div>
        <ul class="b-theme-title-more">
            <li class="start"><span></span>Вступить</li>
            <li class="users"><span><?=\site\frontend\modules\community\helpers\StatsHelper::getSubscribers($club->id)?></span>участники</li>
            <li class="messages"><span><?=\site\frontend\modules\community\helpers\StatsHelper::getSubscribers($club->id)?></span>сообщений</li>
        </ul>
    </div>

    <aside class="right">
        <div class="text-center"><a href="#" class="btn green">Добавить тему</a></div>
        <ul>
            <?php if ($this->beginCache('Forums.UsersTopWidget', array('duration' => 3600))) { $this->widget('\site\frontend\modules\posts\modules\forums\widgets\usersTop\UsersTopWidget', [
                'labels' => [
                    \site\frontend\modules\posts\models\Label::LABEL_FORUMS,
                ],
            ]); $this->endCache(); } ?>
            <?php if ($this->beginCache('Forums.HotPostsWidget', array('duration' => 3600))) { $this->widget('site\frontend\modules\posts\modules\forums\widgets\hotPosts\HotPostsWidget', [
                'labels' => [
                    \site\frontend\modules\posts\models\Label::LABEL_FORUMS,
                    $club->toLabel(),
                ],
            ]); $this->endCache(); } ?>
        </ul>
    </aside>
    
    <?php $this->widget('site\frontend\modules\posts\modules\forums\widgets\feed\FeedWidget', [
        'club' => $club,
        'forum' => $feedForum,
        'tab' => $feedTab,
    ]); ?>
</div>
<?php endif; ?>