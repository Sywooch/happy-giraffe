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
            'activeLinkTemplate' => '<li><a class="b-breadcrumbs__home" href="{url}">{label}</a></li>',
            'inactiveLinkTemplate' => '<li>{label}</li>',
        ]); ?>
    </div>
    <section class="b-top-blocks">
        <ul class="list">
            <li class="item sidebar-widget_item b-widget-wrapper_bordergrunt b-widget-wrapper_outline">
                <?php Yii::beginProfile('HotPostsWidget'); $this->widget('site\frontend\modules\posts\modules\forums\widgets\hotPosts\HotPostsWidget', [
                    'labels' => [
                        \site\frontend\modules\posts\models\Label::LABEL_FORUMS,
                    ],
                ]); Yii::endProfile('HotPostsWidget'); ?>
            </li>
            <li class="item conversion b-widget-wrapper_border">
                <div class="item__img item__img_margin"></div>
                <p>самые актуальные темы для мам и пап</p>
                <?php if (Yii::app()->user->isGuest): ?>
                    <a href="#" class="btn btn-xl green registration-button" data-bind="follow: {}">Присоеденяйтесь!</a>
                <?php endif; ?>
            </li>
            <li class="item statistik sidebar-widget_item">
                <?php Yii::beginProfile('UsersTopWidget'); $this->widget('\site\frontend\modules\posts\modules\forums\widgets\usersTop\UsersTopWidget', [
                    'labels' => [
                        \site\frontend\modules\posts\models\Label::LABEL_FORUMS,
                    ],
                ]); Yii::endProfile('UsersTopWidget'); ?>
            </li>
        </ul>
    </section>
    <?php $this->renderPartial('//site/_home_clubs'); ?>
    <?php Yii::beginProfile('LastPostWidget'); $this->widget('site\frontend\modules\posts\modules\forums\widgets\lastPost\LastPostWidget'); Yii::endProfile('LastPostWidget'); ?>
    <?php Yii::beginProfile('OnlineUsersWidget'); $this->widget('site\frontend\modules\posts\modules\forums\widgets\onlineUsers\OnlineUsersWidget'); Yii::endProfile('OnlineUsersWidget'); ?>
    <div class="text-center">
        <a href="<?=Yii::app()->controller->createUrl('/friends/search/index')?>" class="w-240 btn btn-xl green-btn fontweight-b registration-button" data-bind="follow: {}">Найти друзей</a>
    </div>
</div>