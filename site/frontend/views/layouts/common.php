<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="ie7"> <![endif]-->
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class=""> <!--<![endif]-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
        <?php if ($this->rssFeed !== null): ?>
            <?=CHtml::linkTag('alternate', 'application/rss+xml', $this->rssFeed)?>
        <?php endif; ?>
        <?=CHtml::linkTag('shortcut icon', null, '/favicon.bmp')?>
        <?php
        $cs = Yii::app()->clientScript;
        $cs
            ->registerCssFile('/redactor/redactor.css')
            ->registerCssFile('/stylesheets/common.css')
            ->registerCssFile('/stylesheets/global.css')
            ->registerCssFile('http://fonts.googleapis.com/css?family=Roboto:300&subset=latin,cyrillic-ext')

            ->registerCoreScript('jquery')
            ->registerScriptFile('/javascripts/chosen.jquery.min.js')
            ->registerScriptFile('/javascripts/jquery.powertip.js')
            ->registerScriptFile('/javascripts/jquery.placeholder.min.js')
            ->registerScriptFile('/javascripts/addtocopy.js')
            ->registerScriptFile('/javascripts/jquery.fancybox-1.3.4.js')
            ->registerScriptFile('/javascripts/base64.js')
            ->registerScriptFile('/javascripts/common.js')
            ->registerScriptFile('/javascripts/fox.js')
            ->registerScriptFile('/javascripts/jquery.autosize.min.js')
            ->registerScriptFile('/javascripts/jquery.preload.min.js')
        ;
        if (!empty($this->meta_description))
            $cs->registerMetaTag(trim($this->meta_description), 'description');

        if (!empty($this->meta_keywords))
            $cs->registerMetaTag(trim($this->meta_keywords), 'keywords');
        ?>
        <!--[if IE 7]>
            <link rel="stylesheet" href='/stylesheets/ie.css' type="text/css" media="screen" />
        <![endif]-->
    </head>
    <body class="body-gray<?php if ($this->bodyClass !== null): ?> <?=$this->bodyClass?><?php endif; ?>" id="body">
        <?=$content?>

        <?php if (YII_DEBUG === false): ?>
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
            var _top100q = _top100q || [];

            _top100q.push(["setAccount", "2900190"]);
            _top100q.push(["trackPageviewByLogo", document.getElementById("counter-rambler")]);


            (function(){
                var top100 = document.createElement("script"); top100.type = "text/javascript";

                top100.async = true;
                top100.src = ("https:" == document.location.protocol ? "https:" : "http:") + "//st.top100.ru/top100/top100.js";
                var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(top100, s);
            })();
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

        <!-- Soloway Javascript code START-->
        <script language="javascript" type="text/javascript"><!--
            var RndNum4NoCash = Math.round(Math.random() * 1000000000);
            var ar_Tail='unknown'; if (document.referrer) ar_Tail = escape(document.referrer);
            document.write('<sc' + 'ript language="JavaScript" src="http://ad.adriver.ru/cgi-bin/erle.cgi?sid=196494&bt=16&target=blank&rnd=' + RndNum4NoCash + '&tail256=' + ar_Tail + '"></sc' + 'ript>');
            //--></script>
        <!-- Soloway Javascript code END -->

        <div style="display: none;">
        <a href="#popup-error" id="popup-error-link" class="fancy"></a>
            <div id="popup-error" class="popup popup__error">
                <a class="popup-transparent-close powertip" onclick="$.fancybox.close();" href="javascript:void(0);"></a>
                <div class="error-serv error-serv__rel">
                    <div class="error-serv_hold"></div>
                </div>
            </div>
        </div>

        <?php if (Yii::app()->user->isGuest): ?>
            <?php $this->widget('site.frontend.modules.signup.widgets.LayoutWidget'); ?>
        <?php endif; ?>
    </body>
</html>