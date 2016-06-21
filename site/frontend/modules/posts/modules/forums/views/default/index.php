<?php
/**
 * @var site\frontend\modules\posts\modules\forums\controllers\DefaultController $this
 */
$this->pageTitle = 'Форумы';
$breadcrumbs = [
    'Главная' => ['/site/index'],
    'Форумы',
];
?>

<div class="homepage homepage_adaptive">
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
    <section class="b-top-blocks">
        <ul class="list">
            <li class="item sidebar-widget_item">
                <?php $this->widget('site\frontend\modules\posts\modules\forums\widgets\hotPosts\HotPostsWidget', [
                    'labels' => [
                        \site\frontend\modules\posts\models\Label::LABEL_FORUMS,
                    ],
                ]); ?>
            </li>
            <li class="item conversion"><img src="/images/icons/family.jpg" alt="">
                <p>самые актуальные темы для мам и пап</p>
                <?php if (Yii::app()->user->isGuest): ?>
                    <a href="#" class="btn btn-xl green registration-button" data-bind="follow: {}">Присоеденяйтесь!</a>
                <?php endif; ?>
            </li>
            <li class="item sidebar-widget_item">
                <?php $this->widget('\site\frontend\modules\posts\modules\forums\widgets\usersTop\UsersTopWidget', [
                    'labels' => [
                        \site\frontend\modules\posts\models\Label::LABEL_FORUMS,
                    ],
                ]); ?>
            </li>
        </ul>
    </section>
    <?php $this->renderPartial('//site/_home_clubs'); ?>
    <?php $this->widget('site\frontend\modules\posts\modules\forums\widgets\lastPost\LastPostWidget'); ?>
    <?php $this->widget('site\frontend\modules\posts\modules\forums\widgets\onlineUsers\OnlineUsersWidget'); ?>
    <section class="now-online">
        <div class="text-center"><a href="<?=Yii::app()->controller->createUrl('/friends/search/index')?>" class="w-240 btn btn-xl green registration-button" data-bind="follow: {}">Найти друзей</a></div>
    </section>

</div>