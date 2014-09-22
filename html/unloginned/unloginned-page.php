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
	<div class="layout-header clearfix">
		    <div class="header-banner">
          <div class="header-banner_hold">
            <embed width="660" height="82" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" src="http://www.seotm.com/images/flash/acd-big.swf" play="true" loop="true" menu="true">
          </div>
        </div>
        <!-- header-->
        <header class="header header__guest header__kinder-gold">
          <div class="header_hold clearfix">
            <div class="header-login"><a href="#loginWidget" class="header-login_a popup-a">Вход</a><a href="#registerWidget" class="header-login_a popup-a">Регистрация</a></div>
            <!-- logo-->
            <div class="logo"><a title="Веселый жираф - сайт для всей семьи" href="" class="logo_i">Веселый жираф - сайт для всей семьи</a><span class="logo_slogan">САЙТ ДЛЯ ВСЕЙ СЕМЬИ</span></div>
            <!-- /logo-->
            <!-- header-menu-->
            <div class="header-menu">
              <!-- js улучшить. Закрывать попап при клике не на нем.-->
              <script>
                $(document).ready(function () {
                  $('a.header-menu_a').on('click', function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        var $this = $(this),
                            activeClass = 'active';
                            
                        var $currentPopup =  $this.siblings('div.header-popup');
                        
                        $this
                          .parent()
                            .toggleClass(activeClass)
                            .siblings()
                              .removeClass(activeClass);
                              
                        $this
                          .children('span.header-menu_count:visible')
                          .hide();
                          
                        $(document).on('click', function() {
                            $('li.header-menu_li').removeClass(activeClass);
                            $(this).unbind();
                            $currentPopup.unbind();
                        });
                        
                        $currentPopup.on('click', function (e) {
                          e.stopPropagation();
                        });
                  });
                  });
              </script>
              <ul class="header-menu_ul clearfix">
                <li class="header-menu_li"><a href="#" class="header-menu_a"><span class="header-menu_ico header-menu_ico__giraffe"></span><span class="header-menu_tx">Мой Жираф</span><span class="header-menu_count">1</span></a>
                  <!-- Конверсионный попап-->
                  <div class="header-popup header-popup__club">
                    <div class="header-popup_hold">
                      <div class="header-popup_t">Вступайте в разные клубы на Веселом жирафе!</div>
                      <div class="header-popup_club">
                        <!-- 18 клубов-->
                        <div class="b-clubs">
                          <ul class="b-clubs_ul">
                            <li class="b-clubs_li"><a href="#" class="b-clubs_a">
                                <div class="ico-club ico-club__1"></div>
                                <div class="b-clubs_tx">Планирование</div></a></li>
                            <li class="b-clubs_li"><a href="#" class="b-clubs_a">
                                <div class="ico-club ico-club__2"></div>
                                <div class="b-clubs_tx">Беременность и роды</div></a></li>
                            <li class="b-clubs_li"><a href="#" class="b-clubs_a">
                                <div class="ico-club ico-club__3"></div>
                                <div class="b-clubs_tx">Дети до года</div></a></li>
                            <li class="b-clubs_li"><a href="#" class="b-clubs_a">
                                <div class="ico-club ico-club__4"></div>
                                <div class="b-clubs_tx">Дети старше года</div></a></li>
                            <li class="b-clubs_li"><a href="#" class="b-clubs_a">
                                <div class="ico-club ico-club__5"></div>
                                <div class="b-clubs_tx">Дошкольники</div></a></li>
                            <li class="b-clubs_li"><a href="#" class="b-clubs_a">
                                <div class="ico-club ico-club__6"></div>
                                <div class="b-clubs_tx">Школьники</div></a></li>
                            <li class="b-clubs_li"><a href="#" class="b-clubs_a">
                                <div class="ico-club ico-club__7"></div>
                                <div class="b-clubs_tx">Готовим на кухне</div></a></li>
                            <li class="b-clubs_li"><a href="#" class="b-clubs_a">
                                <div class="ico-club ico-club__8"></div>
                                <div class="b-clubs_tx">Ремонт в доме</div></a></li>
                            <li class="b-clubs_li"><a href="#" class="b-clubs_a">
                                <div class="ico-club ico-club__9"></div>
                                <div class="b-clubs_tx">Домашние хлопоты</div></a></li>
                            <li class="b-clubs_li"><a href="#" class="b-clubs_a">
                                <div class="ico-club ico-club__10"></div>
                                <div class="b-clubs_tx">Сад и огород</div></a></li>
                            <li class="b-clubs_li"><a href="#" class="b-clubs_a">
                                <div class="ico-club ico-club__11"></div>
                                <div class="b-clubs_tx">Наши питомцы</div></a></li>
                            <li class="b-clubs_li"><a href="#" class="b-clubs_a">
                                <div class="ico-club ico-club__12"></div>
                                <div class="b-clubs_tx">Красота и мода</div></a></li>
                            <li class="b-clubs_li"><a href="#" class="b-clubs_a">
                                <div class="ico-club ico-club__13"></div>
                                <div class="b-clubs_tx">Наше здоровье</div></a></li>
                            <li class="b-clubs_li"><a href="#" class="b-clubs_a">
                                <div class="ico-club ico-club__14"></div>
                                <div class="b-clubs_tx">Свадьба</div></a></li>
                            <li class="b-clubs_li"><a href="#" class="b-clubs_a">
                                <div class="ico-club ico-club__15"></div>
                                <div class="b-clubs_tx">Отношения в семье</div></a></li>
                            <li class="b-clubs_li"><a href="#" class="b-clubs_a">
                                <div class="ico-club ico-club__16"></div>
                                <div class="b-clubs_tx">Рукоделие</div></a></li>
                            <li class="b-clubs_li"><a href="#" class="b-clubs_a">
                                <div class="ico-club ico-club__17"></div>
                                <div class="b-clubs_tx">Цветы в доме</div></a></li>
                            <li class="b-clubs_li"><a href="#" class="b-clubs_a">
                                <div class="ico-club ico-club__18"></div>
                                <div class="b-clubs_tx">Наш автомобиль</div></a></li>
                          </ul>
                        </div>
                      </div>
                      <div class="header-popup_b clearfix">
                        <div class="header-popup_btn btn btn-success btn-xl">Присоединяйтесь!</div>
                        <div class="header-popup_b-l"><span class="header-popup_b-tx">Начните прямо сейчас с помощью</span>
                          <div class="ico-social-hold"><a href="#" class="ico-social ico-social__m ico-social__odnoklassniki"></a><a href="#" class="ico-social ico-social__m ico-social__vkontakte"></a></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /Конверсионный попап-->
                </li>
                <!-- Класс active отвечает за видимость попапапа-->
                <li class="header-menu_li"><a href="#" class="header-menu_a"><span class="header-menu_ico header-menu_ico__im"></span><span class="header-menu_tx">вам письмо</span><span class="header-menu_count">1</span></a>
                  <!-- Конверсионный попап-->
                  <div class="header-popup header-popup__msg">
                    <div class="header-popup_hold">
                      <div class="header-popup_t">Общайтесь с миллинами мам и пап на любые темы на Веселом жирафе!</div>
                      <div class="header-popup_msg"></div>
                      <div class="header-popup_b clearfix">
                        <div class="header-popup_btn btn btn-success btn-xl">Присоединяйтесь!</div>
                        <div class="header-popup_b-l"><span class="header-popup_b-tx">Начните прямо сейчас с помощью</span>
                          <div class="ico-social-hold"><a href="#" class="ico-social ico-social__m ico-social__odnoklassniki"></a><a href="#" class="ico-social ico-social__m ico-social__vkontakte"></a></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /Конверсионный попап-->
                </li>
              </ul>
            </div>
            <!-- /header-menu-->
            <a href="#" style="vertical-align: top; margin: 0 7px 0 15px;">
              <img src="/lite/images/banner/header_kindergold.jpg" alt="Kinder"></a>
            <div class="sidebar-search clearfix sidebar-search__big">
              <!-- Форма яндекс поиска--><div class="ya-site-form ya-site-form_inited_no" onclick="return {'action':'','arrow':false,'bg':'transparent','fontsize':12,'fg':'#000000','language':'ru','logo':'rb','publicname':'Yandex Site Search #1883818','suggest':true,'target':'_self','tld':'ru','type':3,'usebigdictionary':true,'searchid':1883818,'webopt':false,'websearch':false,'input_fg':'#000000','input_bg':'#ffffff','input_fontStyle':'normal','input_fontWeight':'normal','input_placeholder':'','input_placeholderColor':'#000000','input_borderColor':'#7f9db9'}"><form action="http://yandex.ru/sitesearch" method="get" target="_self"><input type="hidden" name="searchid" value="1883818"/><input type="hidden" name="l10n" value="ru"/><input type="hidden" name="reqenc" value=""/><input type="text" name="text" value=""/><input type="submit" value="Õ‡ÈÚË"/></form></div><script type="text/javascript">(function(w,d,c){var s=d.createElement('script'),h=d.getElementsByTagName('script')[0],e=d.documentElement;if((' '+e.className+' ').indexOf(' ya-page_js_yes ')===-1){e.className+=' ya-page_js_yes';}s.type='text/javascript';s.async=true;s.charset='utf-8';s.src=(d.location.protocol==='https:'?'https:':'http:')+'//site.yandex.net/v2.0/js/all.js';h.parentNode.insertBefore(s,h);(w[c]||(w[c]=[])).push(function(){Ya.Site.Form.init()})})(window,document,'yandex_site_callbacks');</script>
            </div>
          </div>
        </header>
        <!-- /header-->
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
		<!-- <div class="b-join-row js-b-join-row">
			<div class="b-join-row_hold">
				<div class="b-join-row_logo"></div>
				<div class="b-join-row_tx">Более <span class="b-join-row_tx-big"> 30 000 000</span> мам и пап</div>
				<div class="b-join-row_slogan">уже посетили Веселый Жираф!</div>
				<a href="" class="btn-green btn-h46">Присоединяйтесь!</a>
			</div>
		</div> -->


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