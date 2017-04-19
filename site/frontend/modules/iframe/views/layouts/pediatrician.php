<?php
/**
 * @var $this site\frontend\modules\iframe\controllers\DefaultController
 * @var string $content
 */

$this->beginContent('application.modules.iframe.views._parts.main');
$this->renderSidebarClip();
?>
<div class="b-col__container">
    <div class="padding-iframe-container">
    <?=$content?>
    <aside class="b-main__aside b-col b-col--3 b-hidden-md">
        <?php $this->widget('site\frontend\modules\iframe\widgets\Statistic\CommonStatistic'); ?>

        <div class="b-text--left b-margin--bottom_10">
            <div class="b-sidebar-widget b-sidebar-widget-iframe--blue">
                <div class="b-sidebar-widget__header b-sidebar-widget-header">
                    <div class="b-sidebar-widget-header-title">Рейтинг педиатров</div>
                </div>
                <ul class="b-sidebar-widget-iframe-tab__menu">
                    <li class="active-tab" data-tab="month-specialist"><?=\Yii::app()->dateFormatter->format('LLLL yyyy',time())?></li>
                    <li data-tab="allperiod-specialist">Все время</li>
                </ul>
                <div class="b-sidebar-widget-iframe-tab__content">
                    <div id="month-specialist" class="active-tab">
                        <?php
                        $this->widget('site\frontend\modules\iframe\widgets\usersTop\NewUsersTopWidget', [
                            'titlePrefix'   => 'Педиатр',
                            'onlyUsers'     => FALSE,
                            'allPeriod'     => FALSE,
                            'viewFileName'  => 'iframe_view_specialists',
                        ]);
                        ?>
                    </div>
                    <div id="allperiod-specialist">
                        <?php
                        $this->widget('site\frontend\modules\iframe\widgets\usersTop\NewUsersTopWidget', [
                            'titlePrefix'   => 'Педиатр',
                            'onlyUsers'     => FALSE,
                            'allPeriod'     => TRUE,
                            'viewFileName'  => 'iframe_view_specialists',
                        ]);
                        ?>
                    </div>
                    <span class="b-sidebar-widget-link-b">
                        <a class="b-sidebar-widget-link" href="<?=$this->createUrl('/iframe/default/pediatricianList')?>">Все врачи</a>
                    </span>
                </div>
            </div>
        </div>
<!--        --><?php
//        $this->widget('site\frontend\modules\iframe\widgets\banners\BannersWidget', [
//            'banner'   => [
//                'path' => '/app/builds/static/img/pediatrician/banner-test.png',
//                'url' => '#',
//            ],
//        ]);
//        ?>
    </aside>
    </div>
</div>
<?php $this->endContent(); ?>