<?php $this->beginContent('//layouts/community'); ?>


    <div class="col-23-middle ">

        <?php if (!Yii::app()->user->isGuest):?>
            <div class="clearfix margin-r20 margin-b20 js-community-subscription" data-bind="visible: active">
                <a href="<?=$this->createUrl('/blog/default/form', array('type' => 1, 'club_id' => $this->forum->id)) ?>"
                   class="btn-blue btn-h46 float-r fancy-top">Добавить в клуб</a>
            </div>
        <?php endif ?>

        <?=$content ?>

    </div>
    
    <div class="col-1">
        <?php if ($this->action->id == 'view' || $this->forum->club_id == 11): ?>
            <div class="banner">
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
            </div>
        <?php endif; ?>

        <?php $this->renderPartial('_users2'); ?>

        <?php $this->renderPartial('_rubrics', array('rubrics'=>$this->forum->rootRubrics)); ?>

        <?php if (false): ?>
            <?php $this->widget('CommunityPopularWidget', array('club' => $this->club)); ?>
        <?php endif; ?>

        <?php if ($this->action->id == 'view'): ?>
            <!--AdFox START-->
            <!--giraffe-->
            <!--Площадка: Весёлый Жираф / * / *-->
            <!--Тип баннера: Тексто-графические-->
            <!--Расположение: &lt;сайдбар&gt;-->
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
                document.write('<scr' + 'ipt type="text/javascript" src="//ads.adfox.ru/211012/prepareCode?pp=dey&amp;ps=bkqy&amp;p2=exim&amp;pct=a&amp;plp=a&amp;pli=a&amp;pop=a&amp;pr=' + pr +'&amp;pt=b&amp;pd=' + addate.getDate() + '&amp;pw=' + addate.getDay() + '&amp;pv=' + addate.getHours() + '&amp;prr=' + afReferrer + '&amp;pdw=' + scrwidth + '&amp;pdh=' + scrheight + '"><\/scr' + 'ipt>');
                // -->
            </script>
            <!--AdFox END-->

            <?php if (false): ?>
            <div class="banner">
                <!--  AdRiver code START. Type:extension Site:  PZ: 0 BN: 0 -->
                <script type="text/javascript">
                    (function(L){if(typeof(ar_cn)=="undefined")ar_cn=1;
                        var S='setTimeout(function(e){if(!self.CgiHref){document.close();e=parent.document.getElementById("ar_container_"+ar_bnum);e.parentNode.removeChild(e);}},3000);',
                            j=' type="text/javascript"',t=0,D=document,n=ar_cn;L='' + ('https:' == document.location.protocol ? 'https:' : 'http:') + ''+L+escape(D.referrer||'unknown')+'&rnd='+Math.round(Math.random()*999999999);
                        function _(){if(t++<100){var F=D.getElementById('ar_container_'+n);
                            if(F){try{var d=F.contentDocument||(window.ActiveXObject&&window.frames['ar_container_'+n].document);
                                if(d){d.write('<sc'+'ript'+j+'>var ar_bnum='+n+';'+S+'<\/sc'+'ript><sc'+'ript'+j+' src="'+L+'"><\/sc'+'ript>');t=0}
                                else setTimeout(_,100);}catch(e){try{F.src="javascript:{document.write('<sc'+'ript"+j+">var ar_bnum="+n+"; document.domain=\""
                                +D.domain+"\";"+S+"<\/sc'+'ript>');document.write('<sc'+'ript"+j+" src=\""+L+"\"><\/sc'+'ript>');}";return}catch(E){}}}else setTimeout(_,100);}}
                        D.write('<div style="visibility:hidden;height:0px;left:-1000px;position:absolute;"><iframe id="ar_container_'+ar_cn
                            +'" width=1 height=1 marginwidth=0 marginheight=0 scrolling=no frameborder=0><\/iframe><\/div><div id="ad_ph_'+ar_cn
                            +'" style="display:none;"><\/div>');_();ar_cn++;
                    })('//ad.adriver.ru/cgi-bin/erle.cgi?sid=196494&bt=49&target=blank&tail256=');
                </script>
                <!--  AdRiver code END  -->
            </div>
            <?php endif; ?>

            <?php if (false && $this->action->id == 'view'): ?>
                <div class="contest-tizer contest-tizer__13 clearfix">
                    <div class="contest-tizer_img">
                        <img alt="" src="/images/contest/contest-tizer_img__13.jpg">
                    </div>
                    <div class="contest-tizer_hold">
                        <div class="contest-tizer_tx">Внимание! с 4 декабря стартовал фотоконкурс</div>
                        <a class="contest-tizer_a" href="http://www.happy-giraffe.ru/contest/13/">Моя любимая игрушка</a>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

<?php $this->endContent(); ?>