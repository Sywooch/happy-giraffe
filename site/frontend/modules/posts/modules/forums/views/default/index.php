<?php
/**
 * @var site\frontend\modules\posts\modules\forums\controllers\DefaultController $this
 */
//$this->breadcrumbs = [
//    'Главная' => ['/site/index'],
//    'Форумы',
//];
?>

<div class="homepage homepage_adaptive">
    <div class="b-breadcrumbs">
        <ul>
            <li><a href="#">Главная</a></li>
            <li>Форумы</li>
        </ul>
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
                <a href="#" class="btn btn-xl green registration-button" data-bind="follow: {}">Присоеденяйтесь!</a>
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
</div>