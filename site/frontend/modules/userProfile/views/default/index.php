<?php
/**
 * @var LiteController $this
 * @var \User $user
 */
$this->pageTitle = $user->getFullName() . ' на Веселом Жирафе';
?>

<?php $this->widget('site\frontend\modules\userProfile\widgets\UserSectionWidget', array('user' => $user)); ?>

<div class="b-main_cont b-main_cont__broad">
    <div class="b-main_col-hold clearfix">
        <!--/////     -->
        <!-- Основная колонка-->
        <div class="b-main_col-article">
            <div class="heading-sm">Моя активность</div>

            <?php
            $this->widget('LiteListView', array(
                'dataProvider' => $dataProvider,
                'itemView' => 'site.frontend.modules.posts.views.list._view',
                'tagName' => 'div',
                'itemsTagName' => false,
                'template' => '{items}<div class="yiipagination yiipagination__center">{pager}</div>',
                'pager' => array(
                    'class' => 'LitePager',
                    'maxButtonCount' => 10,
                    'prevPageLabel' => '&nbsp;',
                    'nextPageLabel' => '&nbsp;',
                    'showPrevNext' => true,
                ),
            ));
            ?>

        </div>
        <!--/////-->
        <!-- Сайд бар  -->
        <aside class="b-main_col-sidebar visible-md">
            <?php $this->widget('site\frontend\modules\userProfile\widgets\PhotoWidget', compact('user')); ?>
            <!-- виджет друзья-->
                <friends-section params="userId: <?= $user->id ?>"></friends-section>
            <!-- /виджет друзья-->
            <!-- виджет клубы-->
            <div class="widget-club">
                <div class="heading-sm">Мои клубы</div>
                <ul class="widget-club_ul clearfix">
                    <li class="widget-club_li"><a href="#" class="i-club i-club__list-s i-club__collection-3">
                            <div class="ico-club ico-club__7"></div></a></li>
                    <li class="widget-club_li"><a href="#" class="i-club i-club__list-s i-club__collection-6">
                            <div class="ico-club ico-club__20"></div></a></li>
                    <li class="widget-club_li"><a href="#" class="i-club i-club__list-s i-club__collection-2">
                            <div class="ico-club ico-club__5"></div></a></li>
                    <li class="widget-club_li"><a href="#" class="i-club i-club__list-s i-club__collection-1">
                            <div class="ico-club ico-club__15"></div></a></li>
                </ul>
            </div>
            <!-- /виджет клубы-->

        </aside>
    </div>
</div>