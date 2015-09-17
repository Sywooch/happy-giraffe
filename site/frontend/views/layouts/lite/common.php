<?php
/**
 * @var PersonalAreaController $this
 */
?><!DOCTYPE html><!--[if lt IE 10]>     <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 10]><!--> <html class="no-js "> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <?php if ($this->adaptive): ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php endif; ?>
    <title><?=$this->pageTitle?></title>
    <?=CHtml::linkTag('shortcut icon', null, '/favicon.bmp')?>
    <script>
        function adriver(a,b,c){var d=this,e=a;return this instanceof adriver?("string"==typeof e?e=document.getElementById(a):a=e.id,e?adriver(a)?adriver(a):(d.p=e,d.defer=c,d.prm=adriver.extend(b,{ph:a}),d.loadCompleteQueue=new adriver.queue,d.domReadyQueue=new adriver.queue(adriver.isDomReady),adriver.initQueue.push(function(){d.init()}),adriver.items[a]=d,d):(adriver.isDomReady||adriver.onDomReady(function(){new adriver(a,b,c)}),{})):a?adriver.items[a]:adriver.items}adriver.prototype={isLoading:0,init:function(){},loadComplete:function(){},domReady:function(){},onLoadComplete:function(a){var b=this;return b.loadCompleteQueue.push(function(){a.call(b)}),b},onDomReady:function(a){return this.domReadyQueue.push(a),this},reset:function(){return this.loadCompleteQueue.flush(),this.domReadyQueue.flush(adriver.isDomReady),this}},adriver.extend=function(){for(var a,b,c=arguments[0],d=1,e=arguments.length;e>d;d++){a=arguments[d];for(b in a)a.hasOwnProperty(b)&&(a[b]instanceof Function?c[b]=a[b]:a[b]instanceof Object?c[b]?adriver.extend(c[b],a[b]):c[b]=adriver.extend(a[b]instanceof Array?[]:{},a[b]):c[b]=a[b])}return c},adriver.extend(adriver,{version:"2.3.9",defaults:{tail256:escape(document.referrer||"unknown")},items:{},options:{},plugins:{},pluginPath:{},redirectHost:"//ad.adriver.ru",defaultMirror:"//content.adriver.ru",loadScript:function(a){try{var b=document.getElementsByTagName("head")[0],c=document.createElement("script");c.setAttribute("type","text/javascript"),c.setAttribute("charset","windows-1251"),c.setAttribute("src",a.split("![rnd]").join(Math.round(9999999*Math.random()))),c.onreadystatechange=function(){/loaded|complete/.test(this.readyState)&&(b.removeChild(c),c.onload=null)},c.onload=function(){b.removeChild(c)},b.insertBefore(c,b.firstChild)}catch(d){}},isDomReady:!1,onDomReady:function(a){adriver.domReadyQueue.push(a)},onBeforeDomReady:function(a){adriver.domReadyQueue.unshift(a)},domReady:function(){adriver.isDomReady=!0,adriver.domReadyQueue.execute()},checkDomReady:function(a){try{var b,c,d,e=window,f=e.document,g=function(){adriver.isDomReady||a()};if("complete"===f.readyState)g();else if(f.addEventListener)f.addEventListener("DOMContentLoaded",g,!1),e.addEventListener("load",g,!1);else if(f.attachEvent){d=function(){"complete"===f.readyState&&(f.detachEvent("onreadystatechange",d),g())},f.attachEvent("onreadystatechange",d),e.attachEvent("onload",g),c=!1;try{c=null===e.frameElement&&f.documentElement}catch(h){}c&&c.doScroll&&!function i(){if(!adriver.isDomReady){try{c.doScroll("left")}catch(a){return setTimeout(i,50)}g()}}()}else/WebKit/i.test(navigator.userAgent)?!function(){/loaded|complete/.test(f.readyState)?g():setTimeout(arguments.callee,50)}():(b=e.onload,e.onload=function(){b&&b(),g()})}catch(h){}},onLoadComplete:function(a){return adriver.loadCompleteQueue.push(a),adriver},checkLoadComplete:function(){var a,b;for(a in adriver.items)if(adriver.items.hasOwnProperty(a)&&(b=adriver.items[a],!b.prm.onScroll&&"undefined"==typeof b.reply))return!1;return!0},loadComplete:function(){return adriver.checkLoadComplete()&&adriver.loadCompleteQueue.execute(!1),adriver},setDefaults:function(a){adriver.extend(adriver.defaults,a)},setOptions:function(a){adriver.extend(adriver.options,a)},setPluginPath:function(a){adriver.extend(adriver.pluginPath,a)},queue:function(a){this.q=[],this.flag=a?!0:!1},Plugin:function(a){return this instanceof adriver.Plugin&&a&&!adriver.plugins[a]&&(this.id=a,this.q=new adriver.queue,adriver.plugins[a]=this),adriver.plugins[a]}}),adriver.sync=function(a,b){if(!adriver.syncFlag){adriver.syncFlag=1;for(var c=[];b--;)c[b]=b+1;c.sort(function(){return.5-Math.random()}),adriver.synchArray=c}return adriver.synchArray[(!a||0>=a?1:a)-1]},adriver.queue.prototype={push:function(a){this.flag?a():this.q.push(a)},unshift:function(a){this.flag?a():this.q.unshift(a)},execute:function(a){for(var b,c;b=this.q.shift();)b();a==c&&(a=!0),this.flag=a?!0:!1},flush:function(a){this.q.length=0,this.flag=a?!0:!1}},adriver.Plugin.prototype={loadingStatus:0,load:function(){this.loadingStatus=1,adriver.loadScript((adriver.pluginPath[this.id.split(".").pop()]||adriver.defaultMirror+"/plugins/min/")+this.id+".js")},loadComplete:function(){return this.loadingStatus=2,this.q.execute(),this},onLoadComplete:function(a){return this.q.push(a),this}},adriver.Plugin.require=function(){var a=this,b=0;a.q=new adriver.queue;for(var c,d=0,e=arguments.length;e>d;d++)c=new adriver.Plugin(arguments[d]),2!=c.loadingStatus&&(b++,c.onLoadComplete(function(){1==b--&&a.q.execute()}),c.loadingStatus||c.load());b||a.q.execute()},adriver.Plugin.require.prototype.onLoadComplete=function(a){return this.q.push(a),this},adriver.domReadyQueue=new adriver.queue,adriver.loadCompleteQueue=new adriver.queue,adriver.initQueue=new adriver.queue,adriver.checkDomReady(adriver.domReady),new adriver.Plugin.require("autoUpdate.adriver").onLoadComplete(function(){adriver.initQueue.execute()});
    </script>
</head>
<body class="body body__lite theme body__bg2 <?php if ($this->bodyClass !== null): ?> <?=$this->bodyClass?><?php endif; ?> <?php if (Yii::app()->user->isGuest): ?> body__guest <?php else: ?>  body__user<?php endif; ?>">

<?php if (Yii::app()->vm->version == VersionManager::VERSION_DESKTOP): ?>
<div style="text-align: center; margin-top: 20px;">
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- ƒÓÒÍ‡ -->
    <ins class="adsbygoogle"
         style="display:inline-block;width:970px;height:250px"
         data-ad-client="ca-pub-3807022659655617"
         data-ad-slot="6861468089"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>
<?php endif; ?>

<?php Yii::app()->ads->showCounters(); ?>
<?php if (Yii::app()->user->checkAccess('editMeta')):?>
    <a id="btn-seo" href="/ajax/editMeta/?route=<?=urlencode(Yii::app()->controller->route) ?>&params=<?=urlencode(serialize(Yii::app()->controller->actionParams)) ?>" class="fancy" data-theme="white-square"></a>
<?php endif ?>
<div class="layout-container">
    <div class="layout-loose layout-loose__white">
        <?= $content ?>
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
<?php if (false): ?>
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
<?php endif; ?>
</body></html>