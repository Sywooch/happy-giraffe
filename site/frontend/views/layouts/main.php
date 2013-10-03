﻿<?php
Yii::app()->clientScript
    ->registerCoreScript('yiiactiveform')
    ->registerPackage('ko_layout')
    ->registerPackage('ko_post')
;

if (! Yii::app()->user->isGuest)
    Yii::app()->clientScript
        ->registerPackage('comet')
        ->registerScript('Realplexor-reg', 'comet.connect(\'http://' . Yii::app()->comet->host . '\', \'' . Yii::app()->comet->namespace . '\', \'' . UserCache::GetCurrentUserCache() . '\');')
    ;

$user = Yii::app()->user->getModel();

$this->widget('PhotoCollectionViewWidget', array('registerScripts' => true));
?>

<?php $this->beginContent('//layouts/common'); ?>
<?php if (!Yii::app()->user->isGuest && Yii::app()->user->model->group != UserGroup::USER && Yii::app()->user->checkAccess('commentator_panel')):?>
    <div id="commentator-link" style="position: fixed;top:70px;left: 0;z-index: 200;background:#42ff4c;">
        <a target="_blank" href="<?=$this->createUrl('/signal/commentator/index') ?>" style="color: #333;font-weight:bold;">Панель для работы</a>
    </div>
<?php endif ?>
<div class="layout-container">
    <div class="layout-wrapper">

        <?php if (!Yii::app()->user->isGuest):?>
        <div class="layout-header clearfix">
            <div class="layout-header_hold clearfix">

                <div class="logo">
                    <?=HHtml::link('Веселый жираф - сайт для всей семьи', '/', array('class' => 'logo_i', 'title' => 'Веселый жираф - сайт для всей семьи'), true)?>
                    <span class="logo_slogan">САЙТ ДЛЯ ВСЕЙ СЕМЬИ</span>
                </div>
                    <!-- ko stopBinding: true -->
                    <div class="header-menu layout-binding">
                        <ul class="header-menu_ul clearfix">
                            <li class="header-menu_li" data-bind="css: { active : newPostsCount() > 0 && activeModule() != 'myGiraffe' }">
                                <a href="<?=$this->createUrl('/myGiraffe/default/index', array('type'=>1))?>" class="header-menu_a">
                                    <span class="header-menu_ico header-menu_ico__giraffe"></span>
                                    <span class="header-menu_tx">Мой <br> Жираф</span>
                                    <span class="header-menu_count" data-bind="text: newPostsCount"></span>
                                </a>
                            </li>
                            <li class="header-menu_li" data-bind="css: { active : newNotificationsCount() > 0 && activeModule() != 'notifications' }">
                                <a href="<?=$this->createUrl('/notifications/default/index')?>" class="header-menu_a">
                                    <span class="header-menu_ico header-menu_ico__notice"></span>
                                    <span class="header-menu_tx">Мои <br> уведомления</span>
                                    <span class="header-menu_count" data-bind="text: newNotificationsCount"></span>
                                </a>
                            </li>
                            <li class="header-menu_li">
                                <a href="<?=$this->createUrl('/favourites/default/index')?>" class="header-menu_a">
                                    <span class="header-menu_ico header-menu_ico__favorite"></span>
                                    <span class="header-menu_tx">Мое <br> избранное</span>
                                </a>
                            </li>
                            <li class="header-menu_li header-menu_li__sepor"></li>
                            <li class="header-menu_li">
                                <a href="<?=$user->getUrl() ?>" class="header-menu_a">
                                    <span class="ava middle <?=($user->gender == 0)?'female':'male'?>">
                                        <?php if ($user->online):?><span class="icon-status status-online"></span><?php endif ?>
                                        <?=CHtml::image($user->getAvatarUrl(40)) ?>
                                    </span>
                                    <span class="header-menu_tx">Моя <br> страница</span>
                                </a>
                            </li>
                            <li class="header-menu_li">
                                <a href="<?=Yii::app()->user->model->getFamilyUrl()?>" class="header-menu_a">
                                    <span class="header-menu_ico header-menu_ico__family"></span>
                                    <span class="header-menu_tx">Моя <br> семья</span>
                                </a>
                            </li>
                            <li class="header-menu_li" data-bind="css: { active : newMessagesCount() > 0 && activeModule() != 'messaging' }">
                                <a href="<?=$this->createUrl('/messaging/default/index')?>" class="header-menu_a">
                                    <span class="header-menu_ico header-menu_ico__im"></span>
                                    <span class="header-menu_tx">Мои <br> сообщения</span>
                                    <span class="header-menu_count" data-bind="text: newMessagesCount"></span>
                                </a>
                            </li>
                            <li class="header-menu_li" data-bind="css: { active : newFriendsCount() > 0 && activeModule() != 'friends' }">
                                <a href="<?=$this->createUrl('/friends/default/index')?>" class="header-menu_a">
                                    <span class="header-menu_ico header-menu_ico__friend"></span>
                                    <span class="header-menu_tx">Мои <br> друзья</span>
                                    <span class="header-menu_count" data-bind="text: newFriendsCount"></span>
                                </a>
                            </li>
                            <li class="header-menu_li" data-bind="css: { active : newScoreCount() > 0 && activeModule() != 'scores' }">
                                <a href="<?=$this->createUrl('/scores/default/index')?>" class="header-menu_a">
                                    <span class="header-menu_ico header-menu_ico__award"></span>
                                    <span class="header-menu_tx">Мои <br> успехи</span>
                                    <span class="header-menu_count" data-bind="text: newScoreCount"></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- /ko -->
                    <a href="<?=Yii::app()->createUrl('/site/logout')?>" class="layout-header_logout">Выход</a>
            </div>
        </div>
        <?php else: ?>
            <div class="layout-header layout-header__nologin clearfix">
                <div class="content-cols clearfix">
                    <div class="col-1">
                        <div class="logo">
                            <a href="/" class="logo_i" title="Веселый жираф - сайт для все семьи">Веселый жираф - сайт для все семьи</a>
                            <strong class="logo_slogan">САЙТ ДЛЯ ВСЕЙ СЕМЬИ</strong>
                        </div>
                        <div class="sidebar-search clearfix">
                            <form action="/search/">
                                <input type="text" placeholder="Поиск по сайту" class="sidebar-search_itx" name="query" id="site-search" onkeyup="SiteSearch.keyUp(this)">
                                <input type="button" class="sidebar-search_btn" id="site-search-btn" onclick="return SiteSearch.click()"/>
                            </form>
                        </div>
                    </div>
                    <div class="col-23">
                        <div class="b-join clearfix">
                            <div class="b-join_left">
                                <div class="b-join_tx"> Более <span class="b-join_tx-big"> 20 000 000</span> мам и пап</div>
                                <div class="b-join_slogan">уже посетили Веселый Жираф!</div>
                            </div>
                            <div class="b-join_right">
                                <a href="#register" class="btn-green btn-big fancy">Присоединяйтесь!</a>
                                <div class="clearfix">
                                    <a href="#login" class="display-ib verticalalign-m fancy">Войти</a>
                                    <span class="i-or">или</span>
                                    <?php Yii::app()->eauth->renderWidget(array('action' => 'site/login', 'mode' => 'home')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    $(window).load(function() {
                        /*
                         block - элемент, что фиксируется
                         elementStop - до какого элемента фиксируется
                         blockIndent - отступ
                         */
                        function bJoinRowFixed() {

                            var block = $('.js-b-join-row');
                            var blockTop = block.offset().top;

                            var startTop = $('.layout-header').height();


                            $(window).scroll(function() {
                                var windowScrollTop = $(window).scrollTop();
                                if (windowScrollTop > startTop) {
                                    block.fadeIn();
                                } else {

                                    block.fadeOut();

                                }
                            });
                        }

                        bJoinRowFixed('.js-b-join-row');
                    })
                </script>
                <div class="b-join-row js-b-join-row">
                    <div class="b-join-row_hold">
                        <div class="b-join-row_logo"></div>
                        <div class="b-join-row_tx">Более <span class="b-join-row_tx-big"> 20 000 000</span> мам и пап</div>
                        <div class="b-join-row_slogan">уже посетили Веселый Жираф!</div>
                        <a href="#register" class="btn-green btn-h46 fancy">Присоединяйтесь!</a>
                    </div>
                </div>

                <?php $this->widget('application.widgets.registerWidget.RegisterWidget');
                $this->widget('application.widgets.loginWidget.LoginWidget'); ?>

            </div>
        <?php endif ?>

        <div class="layout-content clearfix<?php if ($this->route == 'messaging/default/index'): ?> margin-b0<?php endif; ?>">
            <?php if (!Yii::app()->user->isGuest && $this->showAddBlock):?>
                <div class="content-cols clearfix">
                    <div class="col-1">
                        <div class="sidebar-search clearfix">
                            <form action="/search/">
                                <input type="text" placeholder="Поиск по сайту" class="sidebar-search_itx" name="query" id="site-search" onkeyup="SiteSearch.keyUp(event, this)">
                                <input type="button" class="sidebar-search_btn" id="site-search-btn" onclick="return SiteSearch.click()"/>
                            </form>
                        </div>
                    </div>
                    <div class="col-23-middle">
                        <?php if (!Yii::app()->user->isGuest):?>
                            <?php if (isset($this->user) && $this->user->id == Yii::app()->user->id):?>
                                <div class="user-add-record clearfix">
                                    <div class="user-add-record_ava-hold">
                                        <?php $this->widget('Avatar', array('user' => Yii::app()->user->getModel())); ?>
                                    </div>
                                    <div class="user-add-record_hold">
                                        <div class="user-add-record_tx">Я хочу добавить</div>
                                        <a href="<?=$this->createUrl('/blog/default/form', array('type' => 1))?>"  class="user-add-record_ico user-add-record_ico__article fancy-top">Статью</a>
                                        <a href="<?=$this->createUrl('/blog/default/form', array('type' => 3))?>"  class="user-add-record_ico user-add-record_ico__photo fancy-top">Фото</a>
                                        <a href="<?=$this->createUrl('/blog/default/form', array('type' => 2))?>"  class="user-add-record_ico user-add-record_ico__video fancy-top">Видео</a>
                                        <a href="<?=$this->createUrl('/blog/default/form', array('type' => 5))?>"  class="user-add-record_ico user-add-record_ico__status fancy-top">Статус</a>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="user-add-record user-add-record__small clearfix">
                                    <div class="user-add-record_ava-hold">
                                        <?php $this->widget('Avatar', array('user' => Yii::app()->user->getModel(), 'size' => 40)); ?>
                                    </div>
                                    <div class="user-add-record_hold">
                                        <div class="user-add-record_tx">Я хочу добавить</div>
                                        <a href="<?= $this->createUrl('/blog/default/form', array('type' => 1)) ?>" class="user-add-record_ico user-add-record_ico__article fancy-top powertip" title="Статью"></a>
                                        <a href="<?= $this->createUrl('/blog/default/form', array('type' => 3)) ?>" class="user-add-record_ico user-add-record_ico__photo fancy-top powertip" title="Фото"></a>
                                        <a href="<?= $this->createUrl('/blog/default/form', array('type' => 2)) ?>" class="user-add-record_ico user-add-record_ico__video fancy-top powertip" title="Видео"></a>
                                        <a href="<?= $this->createUrl('/blog/default/form', array('type' => 5)) ?>" class="user-add-record_ico user-add-record_ico__status fancy-top powertip" title="Статус"></a>
                                    </div>
                                </div>
                            <?php endif ?>
                        <?php endif ?>

                        <?php if (!empty($this->breadcrumbs)):?>
                            <div class="padding-l20">
                                <div class="crumbs-small clearfix">
                                    <?php $this->widget('HBreadcrumbs', array(
                                        'links' => $this->breadcrumbs,
                                    )); ?>
                                </div>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            <?php endif; ?>

            <?=$content?>
        </div>

        <a href="#layout" id="btn-up-page"></a>

        <?php if ($this->route != 'messaging/default/index'): ?>
            <div class="footer-push"></div>
        <?php endif; ?>
    </div>
    <?php if ($this->route != 'messaging/default/index'): ?>
        <?php $this->renderPartial('//_footer'); ?>
    <?php endif; ?>

    <?php if ($this->route == 'services/test/default/view' && $_GET['slug'] == 'pregnancy'): ?>
        <a href="http://ad.adriver.ru/cgi-bin/click.cgi?sid=1&bt=21&ad=420214&pid=1313272&bid=2833663&bn=2833663&rnd=<?=mt_rand(1000000000, 9999999999)?>" class="cover cover-clearblue" target="_blank" onclick="_gaq.push(['_trackEvent','Outgoing Links','www.clearblue.com'])">
            <div class="cover-clearblue_b"></div>
        </a>
    <?php endif; ?>

    <?php if ($this->id == 'contest'): ?>
        <div class="cover cover-contest cover-contest__pets1"></div>
    <?php endif; ?>
</div>
<div class="display-n">
    <?php $sql_stats = YII::app()->db->getStats();
    echo $sql_stats[0] . ' запросов к БД, время выполнения запросов - ' . sprintf('%0.5f', $sql_stats[1]) . ' c.'; ?>
</div>

<script type="text/javascript">
    var userIsGuest = <?=CJavaScript::encode(Yii::app()->user->isGuest)?>;
    var CURRENT_USER_ID = <?=CJavaScript::encode(Yii::app()->user->id)?>;
    <?php if (! Yii::app()->user->isGuest): ?>
        var layoutVM = new LayoutViewModel(<?=CJSON::encode($this->getLayoutData())?>);
        $(".layout-binding").each(function(index, el) {
            ko.applyBindings(layoutVM, el);
        });
    <?php endif; ?>
</script>
<?php $this->endContent(); ?>