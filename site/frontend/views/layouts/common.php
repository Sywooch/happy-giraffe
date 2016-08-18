<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="ie7"> <![endif]-->
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class=""> <!--<![endif]-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="x-dns-prefetch-control" content="on" />
        <link rel="dns-prefetch" href="//plexor.www.happy-giraffe.ru" />
        <link rel="dns-prefetch" href="//img.happy-giraffe.ru" />
            <title><?php
                if (!empty($this->meta_title))
                    echo CHtml::encode(trim($this->meta_title));
                else
                    echo CHtml::encode($this->pageTitle);
                ?></title>
        <?php if ($this->rssFeed instanceof \site\frontend\modules\rss\components\channels\RssChannelAbstract && ! $this->rssFeed->isEmpty()): ?>
            <?=CHtml::linkTag('alternate', 'application/rss+xml', $this->rssFeed->getUrl())?>
        <?php endif; ?>
        <?=CHtml::linkTag('shortcut icon', null, '/favicon.bmp')?>
        <?php
        $cs = Yii::app()->clientScript;
        $cs
            ->registerCssFile('/redactor/redactor.css')
            ->registerCssFile('/stylesheets/common.css')
            ->registerCssFile('/stylesheets/global.css');
            
        if(!$cs->useAMD)
            $cs
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
    <body class="body-gray theme theme__adfox body__bg2 <?php if ($this->bodyClass !== null): ?> <?=$this->bodyClass?><?php endif; ?>" id="body">
        <div class="js-overlay-menu overlay-menu"></div>
        <div class="js-overlay-user overlay-user"></div>

        <?php Yii::app()->ads->showCounters(); ?>

        <?php if (Yii::app()->user->checkAccess('editMeta')):?>
            <a id="btn-seo" href="/ajax/editMeta/?route=<?=urlencode(Yii::app()->controller->route) ?>&params=<?=urlencode(serialize(Yii::app()->controller->actionParams)) ?>" class="fancy" data-theme="white-square"></a>
        <?php endif ?>

        <?=$content?>

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

        <?php if (false): ?>
        <!-- Soloway Javascript code START-->
        <script language="javascript" type="text/javascript"><!--
            var RndNum4NoCash = Math.round(Math.random() * 1000000000);
            var ar_Tail='unknown'; if (document.referrer) ar_Tail = escape(document.referrer);
            document.write('<sc' + 'ript language="JavaScript" src="http://ad.adriver.ru/cgi-bin/erle.cgi?sid=196494&bt=16&target=blank&rnd=' + RndNum4NoCash + '&tail256=' + ar_Tail + '"></sc' + 'ript>');
            //--></script>
        <!-- Soloway Javascript code END -->
        <?php endif; ?>

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