<?php
/**
 * @var LiteController $this
 * @var \User $user
 */
use site\frontend\modules\comments\modules\contest\widgets\ProfileWidget;
use site\frontend\modules\iframe\widgets\activity\ActivityWidget;
use site\frontend\modules\iframe\modules\userProfile\widgets\PhotoWidget;
use site\frontend\modules\iframe\modules\userProfile\widgets\UserSectionWidget;

$this->pageTitle = $user->getFullName() . ' на Веселом Жирафе';
$this->breadcrumbs[] = $this->widget('Avatar', [
    'user' => $user,
    'size' => \Avatar::SIZE_MICRO,
    'tag' => 'span',
], true);
$this->adaptiveBreadcrumbs = true;
?>

<?php $this->widget(UserSectionWidget::class, ['user' => $user, 'showToOwner' => true]); ?>
<div class="b-pediator-iframe">
    <div class="b-main_col-hold clearfix">
        <!--/////     -->
        <!-- Основная колонка-->
        <div class="b-main_col-article">
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
<!--        <aside class="b-main_col-sidebar visible-md">-->
<!--            --><?php
//            $this->widget('site\frontend\modules\iframe\widgets\banners\BannersWidget', [
//                'banner'   => [
//                    'path' => '/app/builds/static/img/pediatrician/banner-test.png',
//                    'url' => '#',
//                ],
//            ]);
//            ?>
<!--        </aside>-->
    </div>
</div>