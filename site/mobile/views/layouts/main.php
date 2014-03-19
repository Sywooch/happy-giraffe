<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head title="Весёлый жираф - мобильная версия">

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
        <meta content="width=device-width, initial-scale=1.0, user-scalable=yes" name="viewport">
        <meta content="telephone=no" name="format-detection">
        <meta content="176" name="/Optimized">
        <title><?=$this->pageTitle?></title>
        <link rel="stylesheet" href="/css/all.css?<?=$this->releaseId?>" type="text/css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
        <script src="http://www.happy-giraffe.ru/javascripts/fox.js"></script>
    </head>
    <body>
        <div class="layout-page">
            <div class="logo">
                <a href="<?=Yii::app()->homeUrl?>" class="logo_a">Веселый жираф</a>
            </div>

            <div class="nav">
                <span class="nav_t" onclick="$('.nav_hold').toggleClass('nav_hold__open');">Разделы</span>
                <div class="nav_hold">
                    <ul class="nav_ul">
                        <li class="nav_li">
                            <a href="javascript:void(0)" onclick="$(this).parent().toggleClass('nav_li__active');" class="nav_i">
                                <i class="nav_ico nav_ico__club"></i>
                                Клубы
                                <span class="nav_arrow-down"></span>
                            </a>
                            <div class="nav-drop">
                                <ul class="nav-drop_ul">
                                    <?php foreach ($this->communities as $community): ?>
                                        <li class="nav-drop_li">
                                            <?=CHtml::link($community->title, $community->url, array('class' => 'nav-drop_i'))?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </li>
                        <li class="nav_li">
                            <a href="<?=Yii::app()->createUrl('/community/blogList')?>" class="nav_i">
                                <i class="nav_ico nav_ico__blog"></i>
                                Блоги
                            </a>
                        </li>
                        <li class="nav_li">
                            <a href="<?=$this->createUrl('/horoscope/index')?>" class="nav_i">
                                <i class="nav_ico nav_ico__horoscope"></i>
                                Гороскопы
                            </a>
                        </li>
                        <li class="nav_li">
                            <a href="javascript:void(0)" onclick="$(this).parent().toggleClass('nav_li__active');" class="nav_i">
                                <i class="nav_ico nav_ico__cook"></i>
                                Рецепты
                                <span class="nav_arrow-down"></span>
                            </a>
                            <div class="nav-drop">
                                <ul class="nav-drop_ul">
                                    <li class="nav-drop_li">
                                        <?=CHtml::link('Обычные', Yii::app()->createUrl('/cook/recipe/index', array('section' => 0)), array('class' => 'nav-drop_i'))?>
                                    </li>
                                    <li class="nav-drop_li">
                                        <?=CHtml::link('Для мультиварки', Yii::app()->createUrl('/cook/recipe/index', array('section' => 1)), array('class' => 'nav-drop_i'))?>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                    <div class="nav-search">
                        <div class="nav-search_hold">
                            <?=CHtml::beginForm('/site/search', 'get')?>
                                <input type="text" name="text" class="nav-search_itx" placeholder="Поиск"/>
                                <input type="submit" class="nav-search_btn btn-green" value="Поиск"/>
                            <?=CHtml::endForm()?>
                        </div>
                    </div>
                </div>
            </div>

            <?=$content?>

            <div style="text-align: center; margin: 20px 0;">
                <!--AdFox START-->
                <!--giraffe-->
                <!--Площадка: Весёлый Жираф / * / *-->
                <!--Тип баннера: Mobile-->
                <!--Расположение: <низ страницы>-->
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
                    document.write('<scr' + 'ipt type="text/javascript" src="http://ads.adfox.ru/211012/prepareCode?pp=i&amp;ps=bkqy&amp;p2=evtc&amp;pct=a&amp;plp=a&amp;pli=a&amp;pop=a&amp;pr=' + pr +'&amp;pt=b&amp;pd=' + addate.getDate() + '&amp;pw=' + addate.getDay() + '&amp;pv=' + addate.getHours() + '&amp;prr=' + afReferrer + '&amp;pdw=' + scrwidth + '&amp;pdh=' + scrheight + '"><\/scr' + 'ipt>');
                    // -->
                </script>
                <!--AdFox END-->
            </div>

            <div class="footer">
                <div class="margin-b5">
                    <a href="http://www.happy-giraffe.ru/?nomo=1" class="full-version">Полная версия</a>
                    <div class="float-r margin-t5">
                        <?php if (Yii::app()->request->pathInfo == ''): ?>
                            <a href="http://waplog.net/c.shtml?517512"><img src="http://c.waplog.net/517512.cnt" alt="waplog" /></a>
                        <?php else: ?>
                            <a href="http://waplog.net/c.shtml?517511"><img src="http://c.waplog.net/517511.cnt" alt="waplog" /></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="clearfix">
                    Веселый Жираф © 2012-2013 <br>Все права защищены
                </div>
            </div>
        </div>

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
        <!--Тип баннера: Fullscreen Mobile-->
        <!--Расположение: <середина страницы>-->
        <!-- ________________________AdFox Asynchronous code START__________________________ -->
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


            var dl = escape(document.location);
            var pr1 = Math.floor(Math.random() * 1000000);

            document.write('<div id="AdFox_banner_'+pr1+'"><\/div>');
            document.write('<div style="visibility:hidden; position:absolute;"><iframe id="AdFox_iframe_'+pr1+'" width=1 height=1 marginwidth=0 marginheight=0 scrolling=no frameborder=0><\/iframe><\/div>');

            AdFox_getCodeScript(1,pr1,'http://ads.adfox.ru/211012/prepareCode?pp=h&amp;ps=bkqy&amp;p2=evcc&amp;pct=a&amp;plp=a&amp;pli=a&amp;pop=a&amp;pr=' + pr +'&amp;pt=b&amp;pd=' + addate.getDate() + '&amp;pw=' + addate.getDay() + '&amp;pv=' + addate.getHours() + '&amp;prr=' + afReferrer + '&amp;dl='+dl+'&amp;pr1='+pr1);
            // -->
        </script>
        <!-- _________________________AdFox Asynchronous code END___________________________ -->
    </body>
</html>