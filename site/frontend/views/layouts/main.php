<?php
/** @var ClientScript $cs */
$cs = Yii::app()->clientScript;

if(! $cs->useAMD) {
    Yii::app()->clientScript
        ->registerCoreScript('yiiactiveform')
        //->registerPackage('ko_layout')
        ->registerPackage('ko_post')
        ->registerPackage('ko_menu')
    ;
}

if (! Yii::app()->user->isGuest) {
    $cometJs = 'comet.connect(\'http://' . Yii::app()->comet->host . '\', \'' . Yii::app()->comet->namespace . '\', \'' . UserCache::GetCurrentUserCache() . '\');';
    $menuJs = "var menuVm = new MenuViewModel( " . CJSON::encode($this->menuData) . ");ko.applyBindings(menuVm, $('.header')[0]);";

    if (! $cs->useAMD) {
        $cs
            ->registerPackage('comet')
            ->registerScript('Realplexor-reg', $cometJs)
            ->registerScript('menuVM', $menuJs)
        ;
    } else {
        $cs
            ->registerAMD('Realplexor-reg', array('common', 'comet'), $cometJs)
            ->registerAMD('menuVM', array('ko' => 'knockout', 'MenuViewModel' => 'ko_menu'), $menuJs)
        ;
    }
}

$js = "var userIsGuest = " . CJavaScript::encode(Yii::app()->user->isGuest) . "; var CURRENT_USER_ID = " . CJavaScript::encode(Yii::app()->user->id);
if($cs->useAMD) {
    $cs->registerScript('isGuest&&userId', $js, ClientScript::POS_AMD);
}
else {
    $cs->registerScript('isGuest&&userId', $js, ClientScript::POS_HEAD);
}

$user = Yii::app()->user->getModel();

$this->widget('PhotoCollectionViewWidget', array('registerScripts' => true));
?>

<?php $this->beginContent('//layouts/common'); ?>
<?php if (!Yii::app()->user->isGuest && Yii::app()->user->model->group != UserGroup::USER && Yii::app()->user->checkAccess('commentator_panel')):?>
    <div id="commentator-link" style="position: fixed;top:70px;left: 0;z-index: 200;background:#42ff4c;">
        <a target="_blank" href="<?=$this->createUrl('/signal/commentator/index') ?>" style="color: #333;font-weight:bold;">Панель для работы</a>
    </div>
<?php endif ?>

<?php $this->renderPartial('application.modules.comments.modules.contest.views._banner'); ?>
<div class="layout-w1">
    <div class="layout-container" id="layout-container">
        <!-- ko stopBinding: true -->
        <div class="layout-header">
            <header class="header header__redesign">
                <?php $this->renderPartial('//_header'); ?>
            </header>
        </div>
        <!-- /ko -->

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
                    <?php if ($this->breadcrumbs): ?>
                        <div class="crumbs-small clearfix">
                            <?php $this->widget('HBreadcrumbs', array(
                                'homeLink' => false,
                                'links' => $this->breadcrumbs,
                            )); ?>
                        </div>
                    <?php endif; ?>

                    <?=$content?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($this->id == 'contest'): ?>
            <div class="cover cover-contest cover-contest__<?=$this->contest->cssClass?>"></div>
        <?php endif; ?>
    </div>
    <?php if ($this->route != 'messaging/default/index'): ?>
        <div class="footer-push"></div>
        <?php $this->renderPartial('//_footer'); ?>
    <?php endif; ?>
</div>

<?php $this->endContent(); ?>
