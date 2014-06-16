<div class="layout-header layout-header__nologin clearfix">
    <div class="header">
        <div class="header_hold">
            <div class="content-cols clearfix">
                <div class="col-1">
                    <div class="logo">
                        <a href="/" class="logo_i" title="Веселый жираф - сайт для все семьи">Веселый жираф - сайт для все семьи</a>
                        <strong class="logo_slogan">САЙТ ДЛЯ ВСЕЙ СЕМЬИ</strong>
                    </div>
                    <div class="sidebar-search sidebar-search__big clearfix">
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
                    <div class="header-login">
                        <a href="#loginWidget" class="header-login_a popup-a">Войти</a>
                        <a href="#registerWidget" class="header-login_a popup-a">Регистрация</a>
                    </div>
                    <div class="header-banner-728-90">
                        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                        <!-- topline-soloway -->
                        <ins class="adsbygoogle"
                             style="display:inline-block;width:728px;height:90px"
                             data-ad-client="ca-pub-3807022659655617"
                             data-ad-slot="2287975288"></ins>
                        <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
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