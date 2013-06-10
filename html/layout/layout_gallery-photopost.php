<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="ie7"> <![endif]-->
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class=""> <!--<![endif]-->
<head>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/head.php'; ?>
	<script>
	
		$(function(){
			
			userDialogsCalc(); // append
			
		})
		
		$(window).bind('resize', function(){
		
			userDialogsCalc();
			
		})
		
		function userDialogsCalc(){
			
			var box = $('#user-dialogs');
			
			var windowH = $(window).height();
			var headerH = 90;
			var textareaH = 100;
			var wannachatH = 140;
			var userH = 110;
			var marginH = 30;
			
			var hasWannachat = box.hasClass('has-wannachat') ? 1 : 0;
			
			var generalH = windowH - marginH*2 - headerH;
			if (generalH < 400) generalH = 400;
			
			box.find('.contacts').height(generalH);
			box.find('.dialog').height(generalH);
			
			box.find('.contacts .list').height(generalH - wannachatH*hasWannachat);
			box.find('.dialog .dialog-messages').height(generalH - textareaH - userH);
						
		}
		
	</script>

</head>
<body class="body-club" style="overflow:hidden;">

	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/top-line-menu.php'; ?>
	
	<div class="layout-container">
		<div class="layout-wrapper">
		<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/layout-header.php'; ?>
			
		<div id="content" class="clearfix">

			<div id="homepage">
				
				<div class="content-cols clearfix">
					
					<div class="col-1">
						
						<div class="box homepage-clubs">
							
							<div class="title">Клубы <span>для общения</span></div>
							
							<ul>
								<li class="kids">
									<div class="category-title">Дети и беременность</div>
									<ul>
										<li>
											<a href="">
												<span class="club-img"><img src="/images/club_img_1.png" /></span>
												<span class="club-title">Планирование</span>
											</a>
										</li>
										<li>
											<a href="">
												<span class="club-img"><img src="/images/club_img_4.png" /></span>
												<span class="club-title">Дети до года</span>
											</a>
										</li>
										<li>
											<a href="">
												<span class="club-img"><img src="/images/club_img_8.png" /></span>
												<span class="club-title">Дети старше года</span>
											</a>
										</li>
										<li>
											<a href="">
												<span class="club-img"><img src="/images/club_img_12.png" /></span>
												<span class="club-title">Дошкольники</span>
											</a>
										</li>
										<li>
											<a href="">
												<span class="club-img"><img src="/images/club_img_15.png" /></span>
												<span class="club-title">Школьники</span>
											</a>
										</li>
										
									</ul>
								</li>
								<li class="manwoman">
									<div class="category-title">Мужчина <span>&amp;</span> женщина</div>
									<ul>
										<li>
											<a href="">
												<span class="club-img"><img src="/images/club_img_19.png" /></span>
												<span class="club-title">Отношения</span>
											</a>
										</li>
										<li>
											<a href="">
												<span class="club-img"><img src="/images/club_img_20.png" /></span>
												<span class="club-title">Свадьба</span>
											</a>
										</li>
									</ul>
								</li>
								<li class="beauty">
									<div class="category-title">Красота и здоровье</div>
									<ul>
										<li>
											<a href="">
												<span class="club-img"><img src="/images/club_img_21.png" /></span>
												<span class="club-title">Красота</span>
											</a>
										</li>
										<li>
											<a href="">
												<span class="club-img"><img src="/images/club_img_22.png" /></span>
												<span class="club-title">Мода и шопинг</span>
											</a>
										</li>
										<li>
											<a href="">
												<span class="club-img"><img src="/images/club_img_23.png" /></span>
												<span class="club-title">Здоровье родителей</span>
											</a>
										</li>
										
									</ul>
								</li>
								<li class="home">
									<div class="category-title">Дом</div>
									<ul>
										<li>
											<a href="">
												<span class="club-img"><img src="/images/club_img_24.png" /></span>
												<span class="club-title">Кулинарные рецепты</span>
											</a>
										</li>
										<li>
											<a href="">
												<span class="club-img"><img src="/images/club_img_25.png" /></span>
												<span class="club-title">Детские рецепты</span>
											</a>
										</li>
										<li>
											<a href="">
												<span class="club-img"><img src="/images/club_img_26.png" /></span>
												<span class="club-title">Интерьер и дизайн</span>
											</a>
										</li>
										<li>
											<a href="">
												<span class="club-img"><img src="/images/club_img_27.png" /></span>
												<span class="club-title">Домашние хлопоты</span>
											</a>
										</li>
										<li>
											<a href="">
												<span class="club-img"><img src="/images/club_img_28.png" /></span>
												<span class="club-title">Загородная жизнь</span>
											</a>
										</li>
										
									</ul>
								</li>
								<li class="hobbies">
									<div class="category-title">Интересы и увлечения</div>
									<ul>
										<li>
											<a href="">
												<span class="club-img"><img src="/images/club_img_29.png" /></span>
												<span class="club-title">Своими руками</span>
											</a>
										</li>
										<li>
											<a href="">
												<span class="club-img"><img src="/images/club_img_30.png" /></span>
												<span class="club-title">Мастерим детям</span>
											</a>
										</li>
										<li>
											<a href="">
												<span class="club-img"><img src="/images/club_img_31.png" /></span>
												<span class="club-title">За рулем</span>
											</a>
										</li>
										<li>
											<a href="">
												<span class="club-img"><img src="/images/club_img_32.png" /></span>
												<span class="club-title">Цветоводство</span>
											</a>
										</li>
										
									</ul>
								</li>
								<li class="rest">
									<div class="category-title">Отдых</div>
									<ul>
										<li>
											<a href="">
												<span class="club-img"><img src="/images/club_img_29.png" /></span>
												<span class="club-title">Выходные с ребенком</span>
											</a>
										</li>
										<li>
											<a href="">
												<span class="club-img"><img src="/images/club_img_30.png" /></span>
												<span class="club-title">Путешествия семьей</span>
											</a>
										</li>
										<li>
											<a href="">
												<span class="club-img"><img src="/images/club_img_31.png" /></span>
												<span class="club-title">Праздники</span>
											</a>
										</li>
									</ul>
								</li>
								
							</ul>
						</div>
						
						<div class="box">
							<a href=""><img src="/images/banner_03.png" /></a>
						</div>
						
					</div>
					
					<div class="col-23">
						
						<div class="box homepage-auth">
							
							<div class="t">
								<p><span>Веселый жираф</span> - это интернет-сообщество, где мамы и папы встречаются каждый день, чтобы общаться, делиться советами, находить новых друзей и многое другое.</p>
								<div class="gray"><b>Это полезно, это интересно и это очень весело!</b></div>
							</div>
							
							<div class="b">
								<a href="" class="register"></a>
								<br/>
								<small>Уже зарегистрированы?</small> &nbsp; <a href="">Войти</a>
							</div>
							
						</div>
						
						<div class="box homepage-auth">
							
							<div class="t">
								<div class="hello">Привет,</div>
							</div>
							
							<div class="b">
								<div class="name">Александр</div>
							</div>
							
						</div>
						
						<div class="clearfix">
					
							<div class="col-2">	
							
								<div class="box homepage-most">
									
									<div class="title">Самое-самое <span>интересное</span></div>
									
									<ul>
										<li>
											<a href="">Самые красивые девушки мира 2012</a>
											<a href=""><img src="/images/homepage_most_img_01.jpg" /></a>
										</li>
										<li>
											<a href="">25 самых красивых мест планеты</a>
											<a href=""><img src="/images/homepage_most_img_02.jpg" /></a>
										</li>
									</ul>
									
								</div>
								
								<div class="box homepage-services">
									
									<div class="title">Сервисы <span>попробуй!</span></div>
									
									<div class="clearfix">
										
										<div class="fast-service child-gender">
											
											<div class="img"><img src="/images/homepage_service_img_01.png" /></div>
											
											<big>Определение пола ребенка</big>
											
											<ul>
												<li><a href="">Китайский метод</a></li>
												<li><a href="">Японский метод</a></li>
												<li><a href="">По дням рождения</a></li>
												<li><a href="">По группе крови</a></li>
												<li><a href="">По овуляции</a></li>
											</ul>
											
										</div>
										
										<div class="fast-service child-name">
											
											<div class="img"><img src="/images/homepage_service_img_02.png" /></div>
											
											<big><a href="">Выбираем имя</a></big>
											
										</div>
										
									</div>
									
									<div class="list clearfix">
										
										<big>Еще сервисы</big>
										
										<ul>
											<li>
												<ul>
													<li><a href="">Календарь прививок ребенка</a></li>
													<li><a href="">Вес при беременности</a></li>
													<li><a href="">Толщина плаценты</a></li>
													<li><a href="">Женский календарь</a></li>
													<li><a href="">Сумка в роддом</a></li>
													<li><a href="">Определение пола ребенка</a></li>
													<li><a href="">Расчет ниток для вышивания</a></li>
													<li><a href="">Сколько пряжи для вязания нужно?</a></li>
												</ul>
											</li>
											<li>
												<ul>
													<li><a href="">Тест. Определение типа волос</a></li>
													<li><a href="">Справочник детских болезней</a></li>
													<li><a href="">Книга народных рецептов от детских болезней</a></li>
													<li><a href="">Женский календарь</a></li>
													<li><a href="">Калькулятор петель</a></li>
													<li><a href="">Расчет стоимости вышивки</a></li>
													<li><a href="">Калькулятор ткани</a></li>
												</ul>
											</li>
											
										</ul>
										
									</div>
									
								</div>
								
								<div class="box homepage-blogs">
									
									<div class="title">Блоги <span>мам и пап</span></div>
									
									<ul>
										<li>
											<div class="clearfix">
												<div class="user-info">
													<a href="" class="ava small female"></a>
													<div class="details">
														<span class="icon-status status-online"></span>
														<a href="" class="username">Александр</a>
													</div>
												</div>
											</div>
											<b><a href="">В гостях у Айболита</b></a>
											<div class="img"><a href=""><img src="/images/homepage_blogs_img_01.jpg" /></a></div>
										</li>
										<li>
											<div class="clearfix">
												<div class="user-info">
													<a href="" class="ava small female"></a>
													<div class="details">
														<span class="icon-status status-online"></span>
														<a href="" class="username">Александр</a>
													</div>
												</div>
											</div>
											<b><a href="">Наш малыш будет похож на папу</b></a>
											<div class="img"><a href=""><img src="/images/homepage_blogs_img_02.jpg" /></a></div>
										</li>
										<li>
											<div class="clearfix">
												<div class="user-info">
													<a href="" class="ava small female"></a>
													<div class="details">
														<span class="icon-status status-offline"></span>
														<a href="" class="username">Александр</a>
													</div>
												</div>
											</div>
											<b><a href="">Фруктовые пюре - ЗА и ПРОТИВ!</b></a>
											<div class="img"><a href=""><img src="/images/homepage_blogs_img_03.jpg" /></a></div>
										</li>
										<li>
											<div class="clearfix">
												<div class="user-info">
													<a href="" class="ava small female"></a>
													<div class="details">
														<span class="icon-status status-offline"></span>
														<a href="" class="username">Александр</a>
													</div>
												</div>
											</div>
											<b><a href="">Почему завтракать – так полезно?</b></a>
											<div class="img"><a href=""><img src="/images/homepage_blogs_img_04.jpg" /></a></div>
										</li>
										<li>
											<div class="clearfix">
												<div class="user-info">
													<a href="" class="ava small female"></a>
													<div class="details">
														<span class="icon-status status-online"></span>
														<a href="" class="username">Александр</a>
													</div>
												</div>
											</div>
											<b><a href="">Социальная помощь – служба помощи семье</b></a>
											<div class="img"><a href=""><img src="/images/homepage_blogs_img_05.jpg" /></a></div>
										</li>
										<li>
											<div class="clearfix">
												<div class="user-info">
													<a href="" class="ava small female"></a>
													<div class="details">
														<span class="icon-status status-offline"></span>
														<a href="" class="username">Александр</a>
													</div>
												</div>
											</div>
											<b><a href="">Кризисы семейной жизни</b></a>
											<div class="img"><a href=""><img src="/images/homepage_blogs_img_06.jpg" /></a></div>
										</li>
										
									</ul>
									
								</div>
								
							</div>
							
							<div class="col-3">
							
								<div class="box homepage-parents clearfix">
									
									<div class="title">Наши <span>мамы и папы</span></div>
									
									<ul>
										<li><a href="" class="ava"></a></li>
										<li><a href="" class="ava male"></a></li>
										<li><a href="" class="ava"></a></li>
										<li><a href="" class="ava female"><img src="http://img.happy-giraffe.ru/avatars/10511/ava/a781a44ec177f6794047f923ac016716.JPG" /></a></li>
										<li><a href="" class="ava male"></a></li>
										<li><a href="" class="ava female"></a></li>
										<li><a href="" class="ava"></a></li>
										<li><a href="" class="ava female"></a></li>
										<li><a href="" class="ava"></a></li>
										<li><a href="" class="ava male"></a></li>
										<li><a href="" class="ava"></a></li>
										<li><a href="" class="ava female"></a></li>
									</ul>
									
									<div class="join">
										<a href="">Присоединяйтесь!</a>
									</div>
									
								</div>
								
								<div class="box homepage-articles">
									
									<div class="title">Интерьер <span>и дизайн</span> <i>- сделаем все красиво!</i></div>
									
									<ul>
										<li><a href=""><img src="/images/homepage_articles_img.jpg" /></a></li>
										<li><a href="">Сделаем хай-тек у себя на кухне собственными силами</a></li>
										<a href=""><li>Состав и свойства наливного пола. Заливаем пол сами</a></li>
									</ul>
									
									<div class="all-link"><a href="">Все статьи (2589)</a></div>
									
								</div>
								
								<div class="box homepage-articles homepage-recipes">
									
									<div class="title">Кулинарные <span>рецепты</span> <i>- <b>1000</b> рецептов</i></div>
									
									<ul>
										<li><a href=""><img src="/images/homepage_recipes_img.jpg" /></a></li>
										<li><a href="">Как приготовить в домашних условиях суши</a></li>
										<li><a href="">У меня очень придирчивые мои любимые дети. Все им не вкусно!</a></li>
									</ul>
									
									<div class="all-link"><a href="">Все рецепты (2589)</a></div>
									
								</div>
								
							</div>
							
						</div>
						
					</div>
					
				</div>
				
			</div>
			
		</div>  	
		
    	<a href="javascript:void(0);" class="tooltip" title="Тайтл" onclick="openPhoto();">Открыть фотку</a>	
    
		<div class="footer-push"></div>
		
		</div>

		<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/footer.php'; ?>
	</div>
	
	<div id="photo-window-bg"></div>
	
	<div id="photo-window">
		
		<!-- <div id="photo-window-in" style="left:8px;"  class="photo-window-banner"> -->
		<div id="photo-window-in" style="left:8px;" >
			
			<div class="photo-bg">
			
				<a href="javascript:void(0);" class="close" onclick="closePhoto();"></a>
					
				 <div class="clearfix">
			
					<div class="album-end">
						
						<div class="album-end_t">
							<span class="album-end_t-tx">ТОП-20 самых модных платьев</span>
							
							<a href="" class="album-end_rewatch">
								<span class="album-end_rewatch-tx">Посмотреть еще раз</span>
							</a>
						</div>
						
						<span class="album-end_like-t">Вам понравился фотопост?  Поделитесь с друзьями!  </span>
						
						<div class="like-block fast-like-block">
														
							<div class="box-1">
								<div class="share_button">
									<div class="fb-custom-like">
										<a href="http://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fdev.happy-giraffe.ru%2Fuser%2F13217%2Fblog%2Fpost22589%2F"
										   onclick="return Social.showFacebookPopup(this);" class="fb-custom-text">
											<i class="pluginButtonIcon img sp_like sx_like_fav"></i>Мне нравится</a>
										<div class="fb-custom-share-count">0</div>
										<script type="text/javascript">
											$.getJSON("http://graph.facebook.com", { id : document.location.href }, function(json){
												$('.fb-custom-share-count').html(json.shares || '0');
											});
										</script>
									</div>
								</div>
								
								<div class="share_button">
									<div class="vk_share_button"></div>
								</div>
								
								<div class="share_button">
									<a class="odkl-klass-oc"
									   href="http://dev.happy-giraffe.ru/user/13217/blog/post22589/"
									   onclick="Social.updateLikesCount('ok'); ODKL.Share(this);return false;"><span>0</span></a>
								</div>
								
								<div class="share_button">
									<div class="tw_share_button">
										<a href="https://twitter.com/share" class="twitter-share-button" data-lang="ru" data-url="http://dev.happy-giraffe.ru/user/13217/blog/post22589/">Твитнуть</a>
										<script type="text/javascript" charset="utf-8">
												if (typeof twttr == 'undefined')
													window.twttr = (function (d,s,id) {
														var t, js, fjs = d.getElementsByTagName(s)[0];
														if (d.getElementById(id)) return; js=d.createElement(s); js.id=id;
														js.src="//platform.twitter.com/widgets.js"; fjs.parentNode.insertBefore(js, fjs);
														return window.twttr || (t = { _e: [], ready: function(f){ t._e.push(f) } });
													}(document, "script", "twitter-wjs"));
										</script>
									</div>
								</div>
								
								<script type="text/javascript">
									$(function () {
										//подписываемся на клик
										if (VK && VK.Share && VK.Share.click) {
											var oldShareClick = VK.Share.click;
											VK.Share.click = function (index, el) {
												Social.updateLikesCount('vk');
												return oldShareClick.call(VK.Share, index, el);
											}
										}

										twttr.ready(function (twttr) {
											twttr.events.bind('tweet', function (event) {
												console.log('tweet');
												Social.updateLikesCount("tw")
											});
										});
									});
								</script>
						
							</div>
							
						</div>					
					</div>
					
							
					<div class="more-albums-photopost">
						<ul class="more-albums-photopost_ul clearfix">
							
							<li class="more-albums-photopost_li">
								<div class="more-albums-photopost_hold">
									<a class="more-albums-photopost_img">
								        <img alt="" src="/images/example/w440-h340.jpg">
								        <span class="more-albums-photopost_img-title">
								        	<span class="more-albums-photopost_img-title-tx"> Пляжная мода: ТОП-15 модных купальников этого лета</span>
								        </span>
								        <span class="more-albums-photopost_count">
								            смотреть <span class="more-albums-photopost_count-big">20 ФОТО</span>
								        </span>
								        <i class="ico-play-big"></i>
								    </a>
								</div>
							</li>
							<li class="more-albums-photopost_li">
								<div class="more-albums-photopost_hold">
									<a class="more-albums-photopost_img">
								        <img alt="" src="/images/example/w440-h340.jpg">
								        <span class="more-albums-photopost_img-title">
								        	<span class="more-albums-photopost_img-title-tx"> Пляжная мода</span>
								        </span>

								        <span class="more-albums-photopost_count">
								            смотреть <span class="more-albums-photopost_count-big">200 ФОТО</span>
								        </span>
								        <i class="ico-play-big"></i>
								    </a>
								</div>
							</li>
							
							
						</ul>
					</div>
						
				</div>
			
				
				
			</div>
			<div id="photo-content">
				<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/comment.php'; ?>
			</div>

		</div>
		
	</div>
	
</body>
</html>
