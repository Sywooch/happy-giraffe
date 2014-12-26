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
            <!-- виджет фото-->
            <div class="widget-user-photo">
                <div class="heading-sm"><a href="#" class="heading-sm_a-r">Все фото 828</a>Мои фото</div>
                <ul class="widget-user-photo_ul clearfix">
                    <li class="widget-user-photo_li"><a href="#" class="widget-user-photo_i"> <img src="http://placecreature.com/dog/300/200" alt="Заголовок фото">
                            <div class="widget-user-photo_overlay">
                                <div class="ico-zoom ico-zoom__abs"></div>
                            </div></a></li>
                    <li class="widget-user-photo_li"><a href="#" class="widget-user-photo_i"> <img src="http://placecreature.com/goldfish/110/70" alt="Заголовок фото">
                            <div class="widget-user-photo_overlay">
                                <div class="ico-zoom ico-zoom__abs ico-zoom__s"></div>
                            </div></a></li>
                    <li class="widget-user-photo_li"><a href="#" class="widget-user-photo_i"> <img src="http://placecreature.com/puppy/80/70" alt="Заголовок фото">
                            <div class="widget-user-photo_overlay">
                                <div class="ico-zoom ico-zoom__abs ico-zoom__s"></div>
                            </div></a></li>
                    <li class="widget-user-photo_li"><a href="#" class="widget-user-photo_i"> <img src="http://placecreature.com/red-panda/90/70" alt="Заголовок фото">
                            <div class="widget-user-photo_overlay">
                                <div class="ico-zoom ico-zoom__abs ico-zoom__s"></div>
                            </div></a></li>
                </ul>
            </div>
            <!-- /виджет фото-->
            <!-- виджет друзья-->
                <friends-section params="userId: <?= $user->id ?>"></friends-section>
            <!-- /виджет друзья-->
            <!-- виджет клубы-->
                <clubs-section params="userId: <?= $user->id ?>"></clubs-section>
            <!-- /виджет клубы-->

        </aside>
    </div>
</div>