<?php $this->beginContent('//layouts/community'); ?>

    <div class="col-1">
        <?php if ($this->action->id == 'view'): ?>
            <!--AdFox START-->
            <!--giraffe-->
            <!--Площадка: Весёлый Жираф / * / *-->
            <!--Тип баннера: Безразмерный 240x400-->
            <!--Расположение: &lt;сайдбар&gt;-->
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

                AdFox_getCodeScript(1,pr1,'http://ads.adfox.ru/211012/prepareCode?pp=dey&amp;ps=bkqy&amp;p2=etcx&amp;pct=a&amp;plp=a&amp;pli=a&amp;pop=a&amp;pr=' + pr +'&amp;pt=b&amp;pd=' + addate.getDate() + '&amp;pw=' + addate.getDay() + '&amp;pv=' + addate.getHours() + '&amp;prr=' + afReferrer + '&amp;dl='+dl+'&amp;pr1='+pr1);
                // -->
            </script>
            <!-- _________________________AdFox Asynchronous code END___________________________ -->
        <?php endif; ?>

        <?php $this->renderPartial('_users2'); ?>
        <?php $this->renderPartial('_rubrics', array('rubrics'=>$this->forum->rootRubrics)); ?>

        <?php if ($this->action->id == 'view'): ?>
            <div class="banner">
                <script async src="http://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- Giraffe - new -->
                <ins class="adsbygoogle"
                     style="display:inline-block;width:240px;height:400px"
                     data-ad-client="ca-pub-3807022659655617"
                     data-ad-slot="4550457687"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
        <?php endif; ?>

        <a href="http://ad.adriver.ru/cgi-bin/click.cgi?sid=1&bt=21&ad=420214&pid=1313272&bid=2833663&bn=2833663&rnd=<?=mt_rand(1000000000, 9999999999)?>" onclick="_gaq.push(['_trackEvent','Outgoing Links','www.clearblue.com'])"><img src="/banners/test.jpg"></a>
    </div>

    <div class="col-23-middle ">

        <?php if (!Yii::app()->user->isGuest):?>
            <div class="clearfix margin-r20 margin-b20 js-community-subscription" data-bind="visible: active">
                <a href="<?= $this->createUrl('/blog/default/form', array('type' => 1, 'club_id' => $this->forum->id)) ?>"
                   class="btn-blue btn-h46 float-r fancy-top">Добавить в клуб</a>
            </div>
        <?php endif ?>

        <div class="col-gray">
            <?=$content ?>
        </div>

    </div>

<?php $this->endContent(); ?>