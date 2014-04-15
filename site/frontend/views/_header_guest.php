<div class="layout-header layout-header__nologin clearfix">
    <div class="header">
        <div class="header_hold">
            <div class="content-cols clearfix">
                <div class="col-1">
                    <div class="logo">
                        <a href="/" class="logo_i" title="Веселый жираф - сайт для все семьи">Веселый жираф - сайт для все семьи</a>
                        <strong class="logo_slogan">САЙТ ДЛЯ ВСЕЙ СЕМЬИ</strong>
                    </div>
                    <div class="sidebar-search clearfix">
                        <form action="/search/">
                            <input type="text" placeholder="Поиск по сайту" class="sidebar-search_itx" name="query" id="site-search" onkeyup="SiteSearch.keyUp(this)">
                            <input type="button" class="sidebar-search_btn" id="site-search-btn" onclick="return SiteSearch.click()"/>
                        </form>
                    </div>
                </div>
                <div class="col-23">
                    <?php if (false): ?>
                    <div class="b-join clearfix">
                        <div class="b-join_left">
                            <div class="b-join_tx"> Более <span class="b-join_tx-big"> 30 000 000</span> мам и пап</div>
                            <div class="b-join_slogan">уже посетили Веселый Жираф!</div>
                        </div>
                        <div class="b-join_right">
                            <a href="#registerWidget" class="btn-green btn-big popup-a">Присоединяйтесь!</a>
                            <div class="clearfix">
                                <a href="#loginWidget" class="display-ib verticalalign-m popup-a">Войти</a>
                                <span class="i-or">или</span>
                                <?php $this->widget('AuthWidget', array('action' => '/signup/login/social')); ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="header-banner-728-90">
                        <!-- Soloway TopLine/728x90 code START-->
                        <script language="javascript" type="text/javascript"><!--
                            (function(L){if(typeof(ar_cn)=="undefined")ar_cn=1;
                                var S='setTimeout(function(e){if(!self.CgiHref){document.close();e=parent.document.getElementById("ar_container_"+ar_bnum);e.parentNode.removeChild(e);}},3000);',
                                    j=' type="text/javascript"',t=0,D=document,n=ar_cn;L+=escape(D.referrer||'unknown')+'&rnd='+Math.round(Math.random()*999999999);
                                function _(){if(t++<100){var F=D.getElementById('ar_container_'+n);
                                    if(F){try{var d=F.contentDocument||(window.ActiveXObject&&window.frames['ar_container_'+n].document);
                                        if(d){d.write('<sc'+'ript'+j+'>var ar_bnum='+n+';'+S+'<\/sc'+'ript><sc'+'ript'+j+' src="'+L+'"><\/sc'+'ript>');t=0}
                                        else setTimeout(_,100);}catch(e){try{F.src="javascript:{document.write('<sc'+'ript"+j+">var ar_bnum="+n+"; document.domain=\""
                                        +D.domain+"\";"+S+"<\/sc'+'ript>');document.write('<sc'+'ript"+j+" src=\""+L+"\"><\/sc'+'ript>');}";return}catch(E){}}}else setTimeout(_,100);}}
                                D.write('<div style="visibility:hidden;height:0px;left:-1000px;position:absolute;"><iframe id="ar_container_'+ar_cn
                                    +'" width=1 height=1 marginwidth=0 marginheight=0 scrolling=no frameborder=0><\/iframe><\/div><div id="ad_ph_'+ar_cn
                                    +'" style="display:none;"><\/div>');_();ar_cn++;
                            })('http://ad.adriver.ru/cgi-bin/erle.cgi?sid=196494&target=blank&bt=43&tail256=');
                            //--></script>
                        <!-- Soloway TopLine/728x90 code END -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).load(function() {
            /*
             block - элемент, что фиксируется
             elementStop - до какого элемента фиксируется
             blockIndent - отступ
             */
            function bJoinRowFixed() {

                var block = $('.js-b-join-row');
                var blockTop = block.offset().top;

                var startTop = $('.layout-header').height();


                $(window).scroll(function() {
                    var windowScrollTop = $(window).scrollTop();
                    if (windowScrollTop > startTop) {
                        block.fadeIn();
                    } else {

                        block.fadeOut();

                    }
                });
            }

            bJoinRowFixed('.js-b-join-row');
        })
    </script>
    <div class="b-join-row js-b-join-row">
        <div class="b-join-row_hold">
            <div class="b-join-row_logo"></div>
            <div class="b-join-row_tx">Более <span class="b-join-row_tx-big"> 30 000 000</span> мам и пап</div>
            <div class="b-join-row_slogan">уже посетили Веселый Жираф!</div>
            <a href="#registerWidget" class="btn-green btn-h46 popup-a">Присоединяйтесь!</a>
        </div>
    </div>

</div>