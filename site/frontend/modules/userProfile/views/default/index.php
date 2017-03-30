<?php
/**
 * @var LiteController $this
 * @var \User $user
 */
use site\frontend\modules\comments\modules\contest\widgets\ProfileWidget;
use site\frontend\modules\som\modules\activity\widgets\ActivityWidget;
use site\frontend\modules\userProfile\widgets\PhotoWidget;
use site\frontend\modules\userProfile\widgets\UserSectionWidget;

$this->pageTitle = $user->getFullName() . ' на Веселом Жирафе';
$this->breadcrumbs[] = $this->widget('Avatar', [
    'user' => $user,
    'size' => \Avatar::SIZE_MICRO,
    'tag' => 'span',
], true);
$this->adaptiveBreadcrumbs = true;
?>

<?php $this->widget(UserSectionWidget::class, ['user' => $user, 'showToOwner' => true]); ?>

<div class="b-main_cont b-main_cont__broad">
    <div class="b-main_col-hold clearfix">
        <!--/////     -->
        <!-- Основная колонка-->
        <div class="b-main_col-article">
            <?php $contestWidget = $this->widget(ProfileWidget::class, [
                'userId' => $user->id,
            ]); ?>
            <?php
            $this->widget(ActivityWidget::class, [
                'setNoindexIfEmpty' => true,
                'setNoindexIfPage' => true,
                'pageVar' => 'page',
                'ownerId' => $user->id,
            ]);
            ?>
        </div>
        <!--/////-->
        <!-- Сайд бар  -->
        <aside class="b-main_col-sidebar visible-md">
            <?php $this->widget(PhotoWidget::class, compact('user')); ?>
            <!-- виджет друзья-->
            <friends-section params="userId: <?= $user->id ?>"></friends-section>
            <!-- /виджет друзья-->
            <!-- виджет клубы-->
            <clubs-section params="userId: <?= $user->id ?>"></clubs-section>
            <!-- /виджет клубы-->

        </aside>
    </div>
</div>