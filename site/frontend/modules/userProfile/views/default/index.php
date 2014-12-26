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
            <div class="widget-friend">
                <div class="heading-sm"> <a href="#" class="heading-sm_a-r">Все друзья 3</a>Мои друзья</div>
                <ul class="ava-list">
                    <li class="ava-list_li">
                        <!-- ava--><a href="#" class="ava ava__middle"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a>
                    </li>
                    <li class="ava-list_li">
                        <!-- ava--><a href="#" class="ava ava__middle"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/189385/74c3062ab78a806abc8d3a3e8990bf0e.jpg" class="ava_img"></a>
                    </li>
                    <li class="ava-list_li">
                        <!-- ava--><a href="#" class="ava ava__middle"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a>
                    </li>
                    <li class="ava-list_li">
                        <!-- ava--><a href="#" class="ava ava__middle"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/189385/74c3062ab78a806abc8d3a3e8990bf0e.jpg" class="ava_img"></a>
                    </li>
                    <li class="ava-list_li">
                        <!-- ava--><a href="#" class="ava ava__middle"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a>
                    </li>
                    <li class="ava-list_li">
                        <!-- ava--><a href="#" class="ava ava__middle"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/189385/74c3062ab78a806abc8d3a3e8990bf0e.jpg" class="ava_img"></a>
                    </li>
                    <li class="ava-list_li">
                        <!-- ava--><a href="#" class="ava ava__middle"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a>
                    </li>
                </ul>
            </div>
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