<?php
/**
 * @var PersonalAreaController $this
 */
?><!DOCTYPE html><!--[if lt IE 10]>     <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 10]><!--> <html class="no-js "> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$this->pageTitle?></title>
    <?=CHtml::linkTag('shortcut icon', null, '/favicon.bmp')?>
</head>
<body class="body body__lite theme body__bg2 <?php if ($this->bodyClass !== null): ?> <?=$this->bodyClass?><?php endif; ?> <?php if (Yii::app()->user->isGuest): ?> body__guest <?php else: ?>  body__user<?php endif; ?>">
<?php Yii::app()->ads->showCounters(); ?>
<?php if (Yii::app()->user->checkAccess('editMeta')):?>
    <a id="btn-seo" href="/ajax/editMeta/?route=<?=urlencode(Yii::app()->controller->route) ?>&params=<?=urlencode(serialize(Yii::app()->controller->actionParams)) ?>" class="fancy" data-theme="white-square"></a>
<?php endif ?>
<div class="layout-container">
    <div class="layout-loose layout-loose__white">
        <div class="layout-loose_hold clearfix">
            <?= $content ?>
        </div>
        <div onclick="$('html, body').animate({scrollTop:0}, 'normal')" class="btn-scrolltop"></div>
    </div>
</div>
<div class="popup-container display-n">
</div>
<!--[if lt IE 9]> <script type="text/javascript" src="/lite/javascript/respond.min.js"></script> <![endif]-->
<script type="text/javascript">
    require(['lite']);
</script>
<?php if (Yii::app()->user->isGuest): ?>
    <?php $this->widget('site.frontend.modules.signup.widgets.LayoutWidget'); ?>
<?php endif; ?>
<!--AdFox START-->
<!--giraffe-->
<!--Площадка: Весёлый Жираф / * / *-->
<!--Тип баннера: Брендирование-->
<!--Расположение: бэкграунд-->
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
    document.write('<scr' + 'ipt type="text/javascript" src="http://ads.adfox.ru/211012/prepareCode?pp=dtx&amp;ps=bkqy&amp;p2=ewfb&amp;pct=a&amp;plp=a&amp;pli=a&amp;pop=a&amp;pr=' + pr +'&amp;pt=b&amp;pd=' + addate.getDate() + '&amp;pw=' + addate.getDay() + '&amp;pv=' + addate.getHours() + '&amp;prr=' + afReferrer + '&amp;pdw=' + scrwidth + '&amp;pdh=' + scrheight + '"><\/scr' + 'ipt>');
    // -->
</script>
<!--AdFox END-->
</body></html>