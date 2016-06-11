<?php
/**
 * @var site\frontend\modules\posts\modules\forums\controllers\DefaultController $this
 * @var CommunityClub $club
 * @var string $feedTab
 * @var null|Community $feedForum
 * @var null|integer $feedLabelId
 */
$this->breadcrumbs = [
    'Главная' => ['/site/index'],
    'Форумы' => ['/posts/forums/default/club', 'club' => $club->slug],
    $club->title,
];
?>

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
            <?php Yii::beginProfile('usersTopWidget'); $this->widget('\site\frontend\modules\posts\modules\forums\widgets\usersTop\UsersTopWidget'); Yii::endProfile('usersTopWidget'); ?>
            <?php Yii::beginProfile('hotWidget'); $this->widget('site\frontend\modules\posts\modules\forums\widgets\hotPosts\HotPostsWidget', [
                'labels' => [
                    \site\frontend\modules\posts\models\Label::LABEL_FORUMS,
                    $club->toLabel(),
                ],
            ]); Yii::endProfile('hotWidget'); ?>
        </ul>
    </aside>
    
    <?php Yii::beginProfile('feedWidget'); $this->widget('site\frontend\modules\posts\modules\forums\widgets\feed\FeedWidget', [
        'club' => $club,
        'forum' => $feedForum,
        'labelId' => $feedLabelId,
        'tab' => $feedTab,
    ]); Yii::endProfile('feedWidget');  ?>
</div>