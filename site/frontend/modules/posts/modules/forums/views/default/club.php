<?php
/**
 * @var site\frontend\modules\posts\modules\forums\controllers\DefaultController $this
 * @var string $tab
 * @var CommunityClub $club
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
            <li class="forummen-month">
                <div class="head">форумчанин июля</div>
                <div class="b-user one">
                    <div class="b-user-number one">1</div>
                    <div class="b-user-ava"><img src="/images/icons/ava.jpg" alt=""></div>
                    <div class="b-user-name">Вероника Петрова</div>
                    <div class="b-user-rating"><span>698</span>баллов</div>
                </div>
                <div class="b-user">
                    <div class="b-user-number two">2</div>
                    <div class="b-user-ava"><img src="/images/icons/ava.jpg" alt=""></div>
                    <div class="b-user-name">Вероника Петрова</div>
                    <div class="b-user-rating"><span>698</span>баллов</div>
                </div>
                <div class="b-user">
                    <div class="b-user-number three">3</div>
                    <div class="b-user-ava"><img src="/images/icons/ava.jpg" alt=""></div>
                    <div class="b-user-name">Вероника Петрова</div>
                    <div class="b-user-rating"><span>698</span>баллов</div>
                </div>
                <div class="b-user">
                    <div class="b-user-number four">4</div>
                    <div class="b-user-ava"><img src="/images/icons/ava.jpg" alt=""></div>
                    <div class="b-user-name">Вероника Петрова</div>
                    <div class="b-user-rating"><span>698</span>баллов</div>
                </div>
                <div class="b-user">
                    <div class="b-user-number five">5</div>
                    <div class="b-user-ava"><img src="/images/icons/ava.jpg" alt=""></div>
                    <div class="b-user-name">Вероника Петрова</div>
                    <div class="b-user-rating"><span>698</span>баллов</div>
                </div>
            </li>
            <li>
                <?php $this->widget('site\frontend\modules\posts\modules\forums\widgets\hotPosts\HotPostsWidget', [
                    'labels' => [$club->toLabel()],
                ]); ?>
            </li>
        </ul>
    </aside>
    <?php $this->widget('site\frontend\modules\posts\modules\forums\widgets\feed\FeedWidget', [
        'club' => $club,
        'tab' => $tab,
    ]); ?>
</div>