<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if lt IE 7]> <html xmlns="http://www.w3.org/1999/xhtml"> <![endif]-->
<!--[if IE 7]>    <html xmlns="http://www.w3.org/1999/xhtml" class="ie7"> <![endif]-->
<!--[if gt IE 7]><!--> <html xmlns="http://www.w3.org/1999/xhtml"> <!--<![endif]-->
<head>
    <?=CHtml::linkTag('shortcut icon', null, '/favicon.bmp')?>
    <?php echo CHtml::metaTag('text/html; charset=utf-8', NULL, 'Content-Type'); ?>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <?php
        $cs = Yii::app()->clientScript;

        $cs
            ->registerCssFile('/stylesheets/common.css')
            ->registerCssFile('/stylesheets/registration.css')
            ->registerCoreScript('jquery')
            ->registerCssFile('/stylesheets/jquery.fancybox-1.3.4.css')
            ->registerScriptFile('/javascripts/jquery.fancybox-1.3.4.pack.js')
            ->registerScriptFile('/javascripts/common.js')
            ->registerCssFile('/stylesheets/ie.css', 'screen')
            ->registerMetaTag('noindex, nofollow', 'robots');
        ;
    ?>
</head>
<body>

<div>

    <div id="registration">

        <div class="header clearfix">

            <div class="a-right login-link">
                <span class="login-q">&mdash; Если Вы уже зарегистрированы?</span>
                <a href="#login" class="btn btn-orange fancy"><span><span>Вход на сайт</span></span></a>
            </div>

            <div class="logo-box"><a href="/" title="hg.ru" class="logo">Ключевые слова сайта</a></div>

        </div>

        <div class="content">

            <?php echo $content; ?>

        </div>


    </div>

    <?php $this->widget('application.widgets.loginWidget.LoginWidget', array(
        'onlyForm' => true,
    )); ?>

    <noindex>
        <!-- Yandex.Metrika counter -->
        <script type="text/javascript">
            (function (d, w, c) {
                (w[c] = w[c] || []).push(function() {
                    try {
                        w.yaCounter11221648 = new Ya.Metrika({id:11221648, enableAll: true, webvisor:true});
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
    </noindex>

</body>
</html>