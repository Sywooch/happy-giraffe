<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="ie7"> <![endif]-->
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class=""> <!--<![endif]-->
<head>
    <?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/head.php'; ?>
    
</head>
<body class="body-gray">
    
<div class="layout-container">
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
                            <input type="text" placeholder="Поиск по сайту" class="sidebar-search_itx" id="" name="">
                            <!-- 
                            В начале ввода текста, скрыть sidebar-search_btn добавить класс active"
                             -->
                            <button class="sidebar-search_btn"></button>
                        </div>
                    </div>
                    <div class="header-login">
                        <a href="#loginWidget" class="header-login_a">Войти</a>
                        <a href="#registerWidget" class="header-login_a">Регистрация</a>
                    </div>

                    <div class="header-banner-728-90">
                        <img src="http://sdelaisait.ru/d/115290/d/728x90.jpg" alt="">
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
                <a href="" class="btn-green btn-h46">Присоединяйтесь!</a>
            </div>
        </div>


    </div>
    <div class="layout-wrapper">

        <div class="layout-content clearfix">
        <div class="b-section b-section__club b-section__club-2">
            <div class="b-section_hold">
                <div class="content-cols clearfix">
                    <div class="col-1">
                        <div class="club-list club-list__large clearfix">
                            <ul class="club-list_ul textalign-c clearfix">
                                <li class="club-list_li club-list_li__in">
                                    <a class="club-list_i" href="">
                                        <span class="club-list_img-hold">
                                            <img class="club-list_img" alt="" src="/images/club/2-w240.png">
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-23-middle clearfix">
                        <div class="b-section_transp">
                            <h1 class="b-section_transp-t">Готовим на кухне</h1>
                            <div class="b-section_transp-desc">Здесь собрано все что нужно для цветоводов. Растения, удобрения <br>чувство юмора имеется, на шею не сажусь, проблемами не загружаю. </div>
                            <div class="b-section_club-moder">
                                <span class="b-section_club-moder-tx">Модераторы <br> клуба</span>
                                <a class="ava" href=""><img src="/images/user_friends_img.jpg"></a>
                                <a href="" class="ava male">
                                    <span class="icon-status status-online"></span>
                                    <img alt="" src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg">
                                </a>
                                <a class="ava female" href=""></a>
                            </div>
                        </div>
                        <ul class="b-section_ul b-section_ul__white clearfix">
                            <li class="b-section_li"><a class="b-section_li-a" href="">Рецепты</a></li>
                            <li class="b-section_li"><a class="b-section_li-a" href="">Для детей</a></li>
                            <li class="b-section_li"><a class="b-section_li-a" href="">Для мультиварки</a></li>
                            <li class="b-section_li"><a class="b-section_li-a" href="">Форум</a></li>
                            <li class="b-section_li"><a class="b-section_li-a" href="">Сервисы</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-cols clearfix">
            <div class="col-1">
            
                <div class="widget-friends clearfix">
                    <div class="clearfix">
                        <span class="heading-small">Участники клуба <span class="color-gray">(1876)</span> </span>
                        
                    </div>
                    <ul class="widget-friends_ul clearfix">
                        <li class="widget-friends_i">
                            <a class="ava male" href="">
                                <span class="icon-status status-online"></span>
                                <img src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg" alt="">
                            </a>
                        </li>
                        <li class="widget-friends_i">
                            <a href="" class="ava female"></a>
                        </li>
                        <li class="widget-friends_i">
                            <a href="" class="ava"><img src="/images/user_friends_img.jpg"></a>
                        </li>
                        <li class="widget-friends_i">
                            <a href="" class="ava"><img src="/images/user_friends_img.jpg"></a>
                        </li>
                        <li class="widget-friends_i">
                            <a href="" class="ava"><img src="/images/user_friends_img.jpg"></a>
                        </li>
                        <li class="widget-friends_i">
                            <a href="" class="ava"><img src="/images/user_friends_img.jpg"></a>
                        </li>
                        <li class="widget-friends_i">
                            <a class="ava male" href="">
                                <span class="icon-status status-online"></span>
                                <img src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg" alt="">
                            </a>
                        </li>
                        <li class="widget-friends_i">
                            <a href="" class="ava"></a>
                        </li>
                        <li class="widget-friends_i">
                            <a href="" class="ava"></a>
                        </li>
                    </ul>
                </div>
                
                <div class="menu-simple">
                    <ul class="menu-simple_ul">
                        <li class="menu-simple_li menu-simple_li__with-drop">
                            <a href="" class="menu-simple_a-drop"></a>
                            <a class="menu-simple_a" href="">Вышивка</a>
                        </li>
                        <li class="menu-simple_li">
                            <a class="menu-simple_a" href="">Шитье</a>
                        </li>
                        <li class="menu-simple_li">
                            <a class="menu-simple_a" href="">Вязание </a>
                        </li>
                        <li class="menu-simple_li">
                            <a class="menu-simple_a" href="">Бижутерия  </a>
                        </li>
                        <li class="menu-simple_li">
                            <a class="menu-simple_a" href="">Скрапбукинг </a>
                        </li>
                        <li class="menu-simple_li">
                            <a class="menu-simple_a" href="">Квиллинг </a>
                        </li>
                        <li class="menu-simple_li">
                            <a class="menu-simple_a" href="">Декупаж </a>
                        </li>
                        <li class="menu-simple_li">
                            <a class="menu-simple_a" href="">Бисероплетение </a>
                        </li>
                        <li class="menu-simple_li">
                            <a class="menu-simple_a" href="">Мыловарение </a>
                        </li>
                        <li class="menu-simple_li">
                            <a class="menu-simple_a" href="">Декоративно-прикладное творчество </a>
                        </li>
                        <li class="menu-simple_li">
                            <a class="menu-simple_a" href="">Фотокружок </a>
                        </li>
                        <li class="menu-simple_li menu-simple_li__with-drop active">
                            <a href="" class="menu-simple_a-drop"></a>
                            <a class="menu-simple_a" href="">Роспись </a>
                            <ul class="menu-simple_ul">
                                <li class="menu-simple_li">
                                    <a class="menu-simple_a" href="">По дереву </a>
                                </li>
                                <li class="menu-simple_li active">
                                    <a class="menu-simple_a" href="">По ткани </a>
                                </li>
                                <li class="menu-simple_li">
                                    <a class="menu-simple_a" href="">По стеклу </a>
                                </li>
                                <li class="menu-simple_li">
                                    <a class="menu-simple_a" href="">По керамике </a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-simple_li">
                            <a class="menu-simple_a" href="">Плетение </a>
                        </li>
                        <li class="menu-simple_li">
                            <a class="menu-simple_a" href="">Валяние из шерсти </a>
                        </li>
                        <li class="menu-simple_li">
                            <a class="menu-simple_a" href="">Декор </a>
                        </li>
                        <li class="menu-simple_li">
                            <a class="menu-simple_a" href="">Новая жизнь старых вещей </a>
                        </li>
                        <li class="menu-simple_li">
                            <a class="menu-simple_a" href="">Куклы своими руками </a>
                        </li>
                        <li class="menu-simple_li">
                            <a class="menu-simple_a" href="">Упаковка подарков </a>
                        </li>
                        <li class="menu-simple_li">
                            <a class="menu-simple_a" href="">Сувениры и поделки из теста </a>
                        </li>
                        <li class="menu-simple_li">
                            <a class="menu-simple_a" href="">Кружево </a>
                        </li>
                        <li class="menu-simple_li">
                            <a class="menu-simple_a" href="">Оригами </a>
                        </li>
                        <li class="menu-simple_li">
                            <a class="menu-simple_a" href="">Пэчворк </a>
                        </li>
                        <li class="menu-simple_li">
                            <a class="menu-simple_a" href="">Канзаши </a>
                        </li>
                        <li class="menu-simple_li">
                            <a class="menu-simple_a" href="">Картонаж </a>
                        </li>
                        <li class="menu-simple_li">
                            <a class="menu-simple_a" href="">Макраме </a>
                        </li>
                        <li class="menu-simple_li">
                            <a class="menu-simple_a" href="">Кофейные зерна </a>
                        </li>
                        <li class="menu-simple_li">
                            <a class="menu-simple_a" href="">Свечи и свечеварение </a>
                        </li>
                    </ul>
                </div>
                
                <div class="banner">
                    <a href="">
                        <img src="/images/banners/8.jpg" alt="">
                    </a>
                </div>
            </div>
            <div class="col-23-middle ">
                <div class="clearfix margin-r20 margin-b20">
                    <a href="" class="btn-blue btn-h46 float-r">Добавить в клуб</a>
                </div>
                <div class="col-gray">
                    <?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/articles.php'; ?>

                </div>
            </div>
        </div>
        </div>
        
        <a href="#layout" id="btn-up-page"></a>
        <div class="footer-push"></div>
    </div>
    <?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/footer.php'; ?>
</div>

<div class="display-n">
    
</div>
</body>
</html>