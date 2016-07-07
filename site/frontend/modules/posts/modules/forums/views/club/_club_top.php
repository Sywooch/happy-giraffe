<?php
/**
 * @var CommunityClub $club
 */

$breadcrumbs = [
    'Главная' => ['/site/index'],
    'Форумы' => ['/posts/forums/default/index'],
    $club->title,
];
?>

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
        <a href="<?=$club->getUrl()?>">
            <div class="b-theme-title-wrapper ico-club__<?=$club->id?>"></div>
            <h1><?=$club->title?></h1>
        </a>
        <p><?=$club->description?></p>
        <?php if (Yii::app()->user->isGuest): ?>
            <a class="start mobile login-button" data-bind="follow: {}"> </a>
        <?php else: ?>
            <a href="<?=$this->createUrl('/blog/default/form', [
                'type' => CommunityContent::TYPE_POST,
                'club_id' => $this->club->id,
                'useAMD' => true,
                'short' => true,
            ])?>" class="start mobile fancy-top"> </a>
        <?php endif; ?>
    </div>
    <ul class="b-theme-title-more">
        <li class="theme-title__item">
            <subscribe params="clubId: <?=$club->id?>, isSubscribed: <?=UserClubSubscription::subscribed(Yii::app()->user->id, $club->id)?>"></subscribe>
        </li>
        <li class="theme-title__item"><span class="theme-title__img users"></span><span class="theme-title__descr"><?=\site\frontend\modules\community\helpers\StatsHelper::getSubscribers($club->id)?></span>участники</li>
        <li class="theme-title__item"><span class="theme-title__img messages"></span><span class="theme-title__descr"><?=\site\frontend\modules\community\helpers\StatsHelper::getComments($club->id)?></span>сообщений</li>
    </ul>
</div>
