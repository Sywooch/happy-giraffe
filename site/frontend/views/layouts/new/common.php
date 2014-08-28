<?php
/* @var $cs ClientScript */
$cs = Yii::app()->clientScript;
// Эти скрипты модуль рагистрирует пакетом, подменим на новые версии для нового шаблона
$cs->scriptMap['jquery.js'] = '/new/javascript/jquery-1.10.2.min.js';
$cs->scriptMap['jquery.js?r=' . Yii::app()->params['releaseId']] = '/new/javascript/jquery-1.10.2.min.js';
$cs->scriptMap['jquery.powertip.js'] = '/new/javascript/jquery.powertip.js';
$cs->scriptMap['jquery.powertip.js?r=' . Yii::app()->params['releaseId']] = '/new/javascript/jquery.powertip.js';
$cs->scriptMap['baron.js'] = '/new/javascript/baron.js';
$cs->scriptMap['baron.js?r=' . Yii::app()->params['releaseId']] = '/new/javascript/baron.js';
$cs->scriptMap['knockout-2.2.1.js'] = '/new/javascript/knockout-3.0.0.js';
$cs->scriptMap['knockout-2.2.1.js?r=' . Yii::app()->params['releaseId']] = '/new/javascript/knockout-3.0.0.js';
$cs->scriptMap['knockout-2.2.1.js'] = '/new/javascript/knockout-debug.3.0.0.js';
$cs->scriptMap['knockout-2.2.1.js?r=' . Yii::app()->params['releaseId']] = '/new/javascript/knockout-debug.3.0.0.js';
if (! Yii::app()->user->isGuest)
{
    if($cs->useAMD)
        $cs
            ->registerAMD('happyDebug', array('happyDebug'), 'happyDebug.log("main", "info", "happyDebug инициализирован");')
            ->registerAMD('Realplexor-reg', array('common', 'comet'), 'comet.connect(\'http://' . Yii::app()->comet->host . '\', \'' . Yii::app()->comet->namespace . '\', \'' . UserCache::GetCurrentUserCache() . '\');');
    else
        $cs
            ->registerPackage('comet')
            ->registerPackage('common')
            ->registerScript('Realplexor-reg', 'comet.connect(\'http://' . Yii::app()->comet->host . '\', \'' . Yii::app()->comet->namespace . '\', \'' . UserCache::GetCurrentUserCache() . '\');');
}

?><!DOCTYPE html>
<html class="no-js">
<head><meta charset="utf-8">
    <?php if (! YII_DEBUG): ?>
    <script type='text/javascript'>
        window.Muscula = { settings:{
            logId:"VwXATrD-QRwMP", suppressErrors: false
        }};
        (function () {
            var m = document.createElement('script'); m.type = 'text/javascript'; m.async = true;
            m.src = (window.location.protocol == 'https:' ? 'https:' : 'http:') +
                '//musculahq.appspot.com/Muscula6.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(m, s);
            window.Muscula.run=function(){var a;eval(arguments[0]);window.Muscula.run=function(){};};
            window.Muscula.errors=[];window.onerror=function(){window.Muscula.errors.push(arguments);
                return window.Muscula.settings.suppressErrors===undefined;}
        })();
    </script>
    <?php endif; ?>
    <title><?php
    if (!empty($this->meta_title))
        echo CHtml::encode(trim($this->meta_title));
    else
        echo CHtml::encode($this->pageTitle);
    ?></title>
    <?=CHtml::linkTag('shortcut icon', null, '/favicon.bmp')?>
    <!-- including .css-->
    <link rel="stylesheet" type="text/css" href="/new/css/all1.css" />
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300&amp;subset=latin,cyrillic-ext,cyrillic">
    <script src="/new/javascript/jquery.tooltipster.js"></script>
    <script src="/new/javascript/modernizr-2.7.1.min.js"></script>
    <!-- wisywig-->
    <script src="/new/redactor/redactor.js"></script>
</head>
<body class="body<?php if ($this->bodyClass !== null): ?> <?=$this->bodyClass?><?php endif; ?>">
<div class="layout-container">
    <div class="error-serv display-n">
        <div class="error-serv_hold"><span class="ico-error-smile margin-r5"></span>Произошла критическая ошибка.<a class="error-serv_a" href="javascript:void(0)" onclick="document.location.reload()">Перезагрузить страницу</a></div>
    </div>
    <?=$content?>
</div>
<div class="display-n"></div>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter11221648 = new Ya.Metrika({id:11221648, enableAll: true, trackHash:true, webvisor:true});
            } catch(e) {}
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/11221648" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<?php if (YII_DEBUG === false): ?>
<script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', '<?=Yii::app()->params['gaCode']  ?>']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
</script>

<script type="text/javascript">
    /*var _top100q = _top100q || [];

    _top100q.push(["setAccount", "2900190"]);
    _top100q.push(["trackPageviewByLogo", document.getElementById("counter-rambler")]);


    (function(){
        var top100 = document.createElement("script"); top100.type = "text/javascript";

        top100.async = true;
        top100.src = ("https:" == document.location.protocol ? "https:" : "http:") + "//st.top100.ru/top100/top100.js";
        var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(top100, s);
    })();*/
</script>
<?php endif; ?>

<?php if (false): ?>
<!-- tns-counter.ru -->
<script type="text/javascript">
    (function(win, doc, cb){
        (win[cb] = win[cb] || []).push(function() {
            try {
                tnsCounterHappygiraffe_ru = new TNS.TnsCounter({
                    'account':'happygiraffe_ru',
                    'tmsec': 'happygiraffe_total'
                });
            } catch(e){}
        });

        var tnsscript = doc.createElement('script');
        tnsscript.type = 'text/javascript';
        tnsscript.async = true;
        tnsscript.src = ('https:' == doc.location.protocol ? 'https:' : 'http:') +
            '//www.tns-counter.ru/tcounter.js';
        var s = doc.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(tnsscript, s);
    })(window, this.document,'tnscounter_callback');
</script>
<noscript>
    <img src="//www.tns-counter.ru/V13a****happygiraffe_ru/ru/UTF-8/tmsec=happygiraffe_total/" width="0" height="0" alt="" />
</noscript>
<!--/ tns-counter.ru -->
<?php endif; ?>

<?php
    $js = "var userIsGuest = " . CJavaScript::encode(Yii::app()->user->isGuest) . "; var CURRENT_USER_ID = " . CJavaScript::encode(Yii::app()->user->id);
    $cs = Yii::app()->clientScript;
    if($cs->useAMD)
        $cs->registerScript('isGuest&&userId', $js, ClientScript::POS_AMD);
    else
        $cs->registerScript('isGuest&&userId', $js, ClientScript::POS_HEAD);
?>

<?php if (Yii::app()->user->isGuest): ?>
    <?php $this->widget('site.frontend.modules.signup.widgets.LayoutWidget'); ?>
<?php endif; ?>
</body>
</html>