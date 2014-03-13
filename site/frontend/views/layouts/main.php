﻿<?php
Yii::app()->clientScript
    ->registerCoreScript('yiiactiveform')
    ->registerPackage('ko_layout')
    ->registerPackage('ko_post')
    ->registerPackage('ko_menu')
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
<div style="display: none;">
    <?php
    var_dump(!Yii::app()->user->isGuest);
    var_dump(Yii::app()->user->model->group != UserGroup::USER);
    var_dump(Yii::app()->user->checkAccess('commentator_panel'));
    var_dump(!Yii::app()->user->isGuest && Yii::app()->user->model->group != UserGroup::USER && Yii::app()->user->checkAccess('commentator_panel'));
    ?>
</div>
<div class="layout-w1">
    <?php if (! Yii::app()->user->isGuest): ?>
        <?php $this->renderPartial('//_menu_fix'); ?>
    <?php endif; ?>
    <div class="layout-container" id="layout-container">
        <?php if (Yii::app()->user->isGuest): ?>
            <?php $this->renderPartial('//_header_guest'); ?>
        <?php else: ?>
            <div class="layout-header clearfix">
                <?php $this->renderPartial('//_menu_base'); ?>
            </div>
        <?php endif; ?>

        <div class="layout-wrapper">
            <?php if (false): ?>
            <div class="layout-wrapper_banner-t" id="layout-wrapper_banner-t">
                <!--AdFox START-->
                <!--giraffe-->
                <!--Площадка: Весёлый Жираф / * / *-->
                <!--Тип баннера: Безразмерный 990х90-->
                <!--Расположение: <верх страницы>-->
                <script type="text/javascript">
                    <!--
                    if (typeof(pr) == 'undefined') { var pr = Math.floor(Math.random() * 1000000); }
                    if (typeof(document.referrer) != 'undefined') {
                        if (typeof(afReferrer) == 'undefined') {
                            afReferrer = escape(document.referrer);
                        }
                    } else {
                        afReferrer = '';
                    }
                    var addate = new Date();
                    var scrheight = '', scrwidth = '';
                    if (self.screen) {
                        scrwidth = screen.width;
                        scrheight = screen.height;
                    } else if (self.java) {
                        var jkit = java.awt.Toolkit.getDefaultToolkit();
                        var scrsize = jkit.getScreenSize();
                        scrwidth = scrsize.width;
                        scrheight = scrsize.height;
                    }
                    document.write('<scr' + 'ipt type="text/javascript" src="http://ads.adfox.ru/211012/prepareCode?pp=g&amp;ps=bkqy&amp;p2=ewsa&amp;pct=a&amp;plp=a&amp;pli=a&amp;pop=a&amp;pr=' + pr +'&amp;pt=b&amp;pd=' + addate.getDate() + '&amp;pw=' + addate.getDay() + '&amp;pv=' + addate.getHours() + '&amp;prr=' + afReferrer + '&amp;pdw=' + scrwidth + '&amp;pdh=' + scrheight + '"><\/scr' + 'ipt>');
                    // -->
                </script>
                <!--AdFox END-->
            </div>
            <?php endif; ?>

            <div class="layout-wrapper_hold">
                <?php if ($this->module !== null && $this->module->id == 'contest'): ?>
                <div class="layout-content margin-l0 clearfix">
                    <div class="content-cols">
                        <div class="col-white">
                            <?=$content?>
                        </div>
                    </div>
                </div>
                <?php else: ?>
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
                                                <a href="<?=$this->createUrl('/blog/default/form', array('type' => 1)) ?>" class="user-add-record_ico user-add-record_ico__article fancy-top powertip" title="Статью"></a>
                                                <a href="<?=$this->createUrl('/blog/default/form', array('type' => 3)) ?>" class="user-add-record_ico user-add-record_ico__photo fancy-top powertip" title="Фото"></a>
                                                <a href="<?=$this->createUrl('/blog/default/form', array('type' => 2)) ?>" class="user-add-record_ico user-add-record_ico__video fancy-top powertip" title="Видео"></a>
                                                <a href="<?=$this->createUrl('/blog/default/form', array('type' => 5)) ?>" class="user-add-record_ico user-add-record_ico__status fancy-top powertip" title="Статус"></a>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                <?php endif ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($this->breadcrumbs): ?>
                        <div class="crumbs-small clearfix">
                            <?php $this->widget('HBreadcrumbs', array(
                                'homeLink' => Yii::app()->user->isGuest ? null : false,
                                'links' => $this->breadcrumbs,
                            )); ?>
                        </div>
                    <?php endif; ?>

                    <?=$content?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($this->route == 'services/test/default/view' && $_GET['slug'] == 'pregnancy'): ?>
            <a href="http://ad.adriver.ru/cgi-bin/click.cgi?sid=1&bt=21&ad=420214&pid=1313272&bid=2833663&bn=2833663&rnd=<?=mt_rand(1000000000, 9999999999)?>" class="cover cover-clearblue" target="_blank" onclick="_gaq.push(['_trackEvent','Outgoing Links','www.clearblue.com'])">
                <div class="cover-clearblue_b"></div>
            </a>
        <?php endif; ?>

        <?php if ($this->id == 'contest'): ?>
            <div class="cover cover-contest cover-contest__<?=$this->contest->cssClass?>"></div>
        <?php endif; ?>
    </div>
    <?php if ($this->route != 'messaging/default/index'): ?>
        <div class="footer-push"></div>
        <?php $this->renderPartial('//_footer'); ?>
    <?php endif; ?>
</div>
<div class="display-n">
    <?php $sql_stats = YII::app()->db->getStats();
    echo $sql_stats[0] . ' запросов к БД, время выполнения запросов - ' . sprintf('%0.5f', $sql_stats[1]) . ' c.'; ?>
</div>

<script type="text/javascript">
    <?php if (! Yii::app()->user->isGuest): ?>
    menuVm = new MenuViewModel(<?=CJSON::encode($this->menuData)?>);
    ko.applyBindings(menuVm, $('.header-fix')[0]);
    ko.applyBindings(menuVm, $('.header')[0]);
    <?php endif; ?>
    var userIsGuest = <?=CJavaScript::encode(Yii::app()->user->isGuest)?>;
    var CURRENT_USER_ID = <?=CJavaScript::encode(Yii::app()->user->id)?>;
</script>

<?php if (Yii::app()->user->isGuest): ?>

<?php endif; ?>
<?php $this->endContent(); ?>