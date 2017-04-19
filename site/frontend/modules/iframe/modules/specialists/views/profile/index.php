<?php
/**
 * @var LiteController $this
 * @var CActiveDataProvider $dp
 */
use site\frontend\modules\iframe\widgets\activity\ActivityWidget;
$this->pageTitle = $this->user->getFullName() . ' на Веселом Жирафе';
?>

<?php $this->renderPartial('_userSection', ['user' => $this->user]); ?>
<div class="b-pediator-iframe">
    <div class="b-col b-col--6 b-col-sm--10 b-col-xs">
        <?php
        $this->widget(ActivityWidget::class, [
            'setNoindexIfEmpty' => true,
            'setNoindexIfPage' => true,
            'pageVar' => 'page',
            'ownerId' => $this->user->id,
        ]);
        ?>
    </div>
<!--    <div class="b-main__aside b-col b-col--3 b-hidden-md">-->
<!--        --><?php
//        $this->widget('site\frontend\modules\iframe\widgets\banners\BannersWidget', [
//            'banner'   => [
//                'path' => '/app/builds/static/img/pediatrician/banner-test.png',
//                'url' => '#',
//            ],
//        ]);
//        ?>
<!--    </div>-->
</div>