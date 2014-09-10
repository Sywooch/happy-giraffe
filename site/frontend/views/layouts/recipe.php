<?php $this->beginContent('//layouts/community'); ?>

<div class="content-cols clearfix">
    <div class="col-1">

        <?php if ($this->action->id == 'view'): ?>
            <?php $this->beginWidget('AdsWidget'); ?>
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
            <?php $this->endWidget(); ?>
        <?php endif; ?>

        <?php $this->renderPartial('application.modules.community.views.default._users2'); ?>

        <div class="sidebar-search sidebar-search__gray clearfix">
            <?=CHtml::beginForm(array('search'), 'get')?>
            <input type="text" placeholder="Поиск из <?=CookRecipe::model()->count()?> рецептов" class="sidebar-search_itx" name="query">
            <button class="sidebar-search_btn"></button>
            <?=CHtml::endForm()?>
        </div>

        <div class="menu-simple">
            <ul class="menu-simple_ul">
                <?php foreach (CActiveRecord::model($this->modelName)->types as $id => $label): ?>
                    <li class="menu-simple_li<?php if ($this->currentType == $id): ?> active<?php endif; ?>">
                        <?=HHtml::link($label, $this->getTypeUrl($id), array('class' => 'menu-simple_a'), true)?>
                        <div class="menu-simple_count"><?=isset($this->counts[$id]) ? $this->counts[$id] : 0?></div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <?php if ($this->action->id == 'view'): ?>
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
    </div>
    <div class="col-23-middle ">


        <div class="clearfix margin-r20 margin-b20">
            <a href="<?=(Yii::app()->user->isGuest) ? '#login' : $this->createUrl('/cook/recipe/form', array('section' => $this->section))?>" class="btn-blue btn-h46 float-r">Добавить рецепт</a>
        </div>
        <div class="clearfix">

            <?=$content?>

        </div>
    </div>
</div>

<?php $this->endContent(); ?>