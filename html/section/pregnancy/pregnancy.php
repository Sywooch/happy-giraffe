<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="ie7"> <![endif]-->
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class=""> <!--<![endif]-->
<head>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/head.php'; ?>
</head>
<body>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/top-line-menu.php'; ?>
	
<div class="layout-container">
	<div class="layout-wrapper">
		<!-- Вставка секции в шапке страницы, размер изображения 195*115px -->
		<?php $headerSection = '
		<a class="layout-header-section_a" href="">
			<img alt="" src="/images/section/pregnancy/layout-header-section_img.jpg" class="layout-header-section_img">
			<span class="layout-header-section_text">Беременность и роды</span>
		</a>
		'?>
		<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/layout-header.php'; ?>
		
			<div class="section section__blue">
				<div class="section_hold">
					<div class="box-two-transp">
						<div class="box-two-transp_hold clearfix">
							<div class="child-calendar-steps">
								<div class="child-calendar-steps_t">Календарь развития вашего ребенка</div>
								<ul class="child-calendar-steps_ul clearfix">
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a w-90 js-tooltipsy" title="Планирование">
											<i class="ico-pregnant-test"></i>
											Планирование
										</a>
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue-light js-tooltipsy" title="1-я неделя"></a>
										<div class="child-calendar-steps_flag"><span class="child-calendar-steps_flag-ico"></span> 1 триместр</div> 
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue-light js-tooltipsy" title="2-я неделя"></a>
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue-light js-tooltipsy" title="3-я неделя"></a>
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue-light js-tooltipsy" title="4-я неделя"></a>
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__pregnancy js-tooltipsy" title="5-я неделя"></a>
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue-light js-tooltipsy" title="6-я неделя"></a>
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue-light js-tooltipsy" title="7-я неделя"></a>
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue-light js-tooltipsy" title="8-я неделя"></a>
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue-light js-tooltipsy" title="9-я неделя"></a>
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue-light js-tooltipsy" title="10-я неделя"></a>
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue-light js-tooltipsy" title="11-я неделя"></a>
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue-light js-tooltipsy" title="12-я неделя"></a>
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue js-tooltipsy" title="13-я неделя"></a>
										<div class="child-calendar-steps_flag"><span class="child-calendar-steps_flag-ico"></span> 2 триместр</div>        
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue js-tooltipsy" title="14-я неделя"></a>       
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue js-tooltipsy" title="15-я неделя"></a>       
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue js-tooltipsy" title="16-я неделя"></a>       
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue js-tooltipsy" title="17-я неделя"></a>       
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue js-tooltipsy" title="18-я неделя"></a>       
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue js-tooltipsy" title="19-я неделя"></a>       
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue js-tooltipsy" title="20-я неделя"></a>       
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue js-tooltipsy" title="21-я неделя"></a>       
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue js-tooltipsy" title="22-я неделя"></a>       
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue js-tooltipsy" title="23-я неделя"></a>       
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue js-tooltipsy" title="24-я неделя"></a>       
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue js-tooltipsy" title="25-я неделя"></a>       
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue js-tooltipsy" title="26-я неделя"></a>       
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue js-tooltipsy" title="27-я неделя"></a>       
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue-dark js-tooltipsy" title="28-я неделя"></a>
										<div class="child-calendar-steps_flag"><span class="child-calendar-steps_flag-ico"></span>3 триместр</div>       
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue-dark js-tooltipsy" title="29-я неделя"></a>       
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue-dark js-tooltipsy" title="30-я неделя"></a>       
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue-dark js-tooltipsy" title="31-я неделя"></a>       
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue-dark js-tooltipsy" title="32-я неделя"></a>       
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue-dark js-tooltipsy" title="33-я неделя"></a>       
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue-dark js-tooltipsy" title="34-я неделя"></a>       
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue-dark js-tooltipsy" title="35-я неделя"></a>       
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue-dark js-tooltipsy" title="36-я неделя"></a>       
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue-dark js-tooltipsy" title="37-я неделя"></a>       
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue-dark js-tooltipsy" title="38-я неделя"></a>       
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue-dark js-tooltipsy" title="39-я неделя"></a>       
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a child-calendar-steps_a__blue-dark js-tooltipsy" title="40-я неделя"></a>       
									</li>
									<li class="child-calendar-steps_li">
										<a href="" class="child-calendar-steps_a w-90 child-calendar-steps_a__blue-dark js-tooltipsy" title="Роды">Роды</a>
										<i class="ico-childbirth"></i>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="content-cols clearfix">
						<div class="col-1">
							<div class="section-menu">
								<div class="section-menu-top">
									<div class="section-menu_t">Клубы для общения<div class="section-menu_t-blue">будущих мам</div></div>
								</div>
							</div>
							
							<div class="section-clubs">
								<ul>
									<li class="section-clubs_li clearfix">
										<a href="" class="section-clubs_img kids"><img src="/images/club_img_1.png" alt=""></a>
										<div class="section-clubs_hold">
											<a href="" class="section-clubs_t">Планирование</a>
											<div class="section-clubs_comment">
												<i class="ico-comment"></i> 25 036
											</div>
											<a href="" class="section-clubs_join">Вступить</a>
										</div>
									</li>
									<li class="section-clubs_li clearfix">
										<a href="" class="section-clubs_img kids"><img src="/images/club_img_2.png" alt=""></a>
										<div class="section-clubs_hold">
											<a href="" class="section-clubs_t">Беременность</a>
											<div class="section-clubs_comment">
												<i class="ico-comment"></i> 25 036
											</div>
											<a href="" class="section-clubs_join">Вступить</a>
										</div>
									</li>
									<li class="section-clubs_li clearfix">
										<a href="" class="section-clubs_img kids"><img src="/images/club_img_3.png" alt=""></a>
										<div class="section-clubs_hold">
											<a href="" class="section-clubs_t">Подготовка и роды</a>
											<div class="section-clubs_comment">
												<i class="ico-comment"></i> 25 036
											</div>
											<a href="" class="section-clubs_join">Вступить</a>
										</div>
									</li>
								</ul>
							</div>
						
						</div>
						<div class="col-23-big">
							<div class="section-cnt">
		<script>
		$(window).load(function() {
			$('.js-isotop').isotope({
				itemSelector : '.masonry-news-list_item',
				 masonry: {
					columnWidth: 240
				}
			});
		});
		</script>
								<div class="masonry-news-list clearfix">
							<ul class="js-isotop">
								<li class="masonry-news-list_item">
									<h3 class="masonry-news-list_title">
										<a href="">Волшебная азбука</a>
									</h3>
									<div class="masonry-news-list_meta-info clearfix">
										
										<div class="meta">
											<div class="views"><span class="icon" href="#"></span> <span>265</span></div>
											<div class="comments">
												<a class="icon" href="#"></a>
												<a href="">15233</a>
											</div>
										</div>
										
										<div class="user-info">
											<a class="ava female small"><img alt="" src="http://img.happy-giraffe.ru/avatars/19372/small/21fd8c8f29c5a289df17938cb2f20e5b.jpg"></a>
											<div class="details">
												<a class="username" href="">Александр</a>
												<span class="date">Сегодня 13:25</span>
											</div>
										</div>
									</div>
									<div class="masonry-news-list_content">
										<img src="/images/example/gallery_album_img_10.jpg" alt="" />
										<p>Роды — отправная точка для самых важных изменений и судьбоносных... <a href="" class="all">Весь рецепт </a></p>
									</div>
								</li>
								<li class="masonry-news-list_item">
									<h3 class="masonry-news-list_title">
										<a href="">Волшебная азбука. Раннее развитие и обучение.</a>
									</h3>
									<div class="masonry-news-list_meta-info clearfix">
										
										<div class="meta">
											<div class="views"><span class="icon" href="#"></span> <span>11265</span></div>
											<div class="comments empty">
												<a class="icon" href="#"></a>
											</div>
										</div>
										
										<div class="user-info">
											<a class="ava female small"></a>
											<div class="details">
												<a class="username" href="">Александр Богоявленский</a>
												<span class="date">Сегодня 13:25</span>
											</div>
										</div>
									</div>
									<div class="masonry-news-list_content">
										<p>Роды — отправная точка для самых важных изменений и судьбоносных... <a href="" class="all">Весь рецепт </a></p>
									</div>
								</li>
								<li class="masonry-news-list_item">
									<h3 class="masonry-news-list_title">
										<a href="">Волшебная азбука</a>
									</h3>
									<div class="masonry-news-list_meta-info clearfix">
										
										<div class="meta">
										</div>
										
										<div class="user-info">
											<a class="ava female small"></a>
											<div class="details">
												<a class="username" href="">Александр Богоявленский</a>
												<span class="date">Сегодня 13:25</span>
											</div>
										</div>
									</div>
									<div class="masonry-news-list_content">
										<img src="/images/example/gallery_album_img_10.jpg" alt="" />
									</div>
								</li>
								<li class="masonry-news-list_item">
									<h3 class="masonry-news-list_title">
										<a href="">Волшебная азбука</a>
									</h3>
									<div class="masonry-news-list_meta-info clearfix">
										
										<div class="meta">
											<div class="views"><span class="icon" href="#"></span> <span>265</span></div>
											<div class="comments">
												<a class="icon" href="#"></a>
												<a href="">15233</a>
											</div>
										</div>
										
										<div class="user-info">
											<a class="ava female small"></a>
											<div class="details">
												<a class="username" href="">Александр</a>
												<span class="date">Сегодня 13:25</span>
											</div>
										</div>
									</div>
									<div class="masonry-news-list_content">
										<img src="/images/example/gallery_album_img_10.jpg" alt="" />
										<p>Роды — отправная точка для самых важных изменений и судьбоносных... <a href="" class="all">Весь рецепт </a></p>
									</div>
								</li>
								<li class="masonry-news-list_item  masonry-news-list_item__decor-no recent-banner-article blue">
								
										<a href="#">
											<span class="img">
												<img width="240" alt="" src="/images/example/left-sidebar-test-2.jpg">
											</span>
											<span class="title-box">
												<span class="title">Обязательства мешают любовным отношениям</span>
												<span class="statistic clearfix">
													<i class="icon-eye"></i> 265
													<i class="icon-comment"></i> 12
												</span>
											</span>
										</a>
							 
								</li>
								<li class="masonry-news-list_item masonry-news-list_item__decor-no recent-banner-article green">
								
										<a href="#">
											<span class="count-photo">25 фото</span>
											<span class="img">
												<img width="240" alt="" src="/images/example/left-sidebar-test-1.jpg">
											</span>
											<span class="title-box">
												<span class="title">Как выбрать детскую кроватку?</span>
												<span class="statistic clearfix">
													<i class="icon-eye"></i> 265
													<i class="icon-comment"></i> 12
												</span>
											</span>
										</a>
								 
								</li>
							</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<div class="layout-content clearfix">
			<div class="services-list">
				<div class="services-list_t">Полезные сервисы. <span class="color-blue"> Для будущих мам!</span></div>
				<ul>
					<li>
						<div class="img"><a href=""><img src="/images/services/service_img_1.png"></a></div>
						<div class="text">
							<div class="item-title"><a href="">Выбор имени для ребенка</a></div>
							<p>Стали обладательницей мультиварки? Выбирайте подходящий рецепт здесь.</p>
						</div>
					</li>
					<li>
						<div class="img"><a href=""><img src="/images/services/service_img_5.png"></a></div>
						<div class="text">
							<div class="item-title"><a href="">Вес при беременности</a></div>
							<p>Сервис для перевода веса и объема продуктов в понятные для вас меры.</p>
						</div>
					</li>
					<li>
						<div class="img"><a href=""><img src="/images/services/service_img_6.png"></a></div>
						<div class="text">
							<div class="item-title"><a href="">Толщина плаценты</a></div>
							<p>Узнавайте сколько калорий, а также белков, жиров и углеводов в любых </p>
						</div>
					</li>
					<li>
						<div class="img"><a href=""><img src="/images/services/service_img_7.png"></a></div>
						<div class="text">
							<div class="item-title"><a href="">Считаем схватки</a></div>
							<p>Стали обладательницей мультиварки? Выбирайте подходящий рецепт здесь.</p>
						</div>
					</li>
					<li>
						<div class="img"><a href=""><img src="/images/services/service_img_8.png"></a></div>
						<div class="text">
							<div class="item-title"><a href="">Определение пола ребенка</a></div>
							<p>Сервис для перевода веса и объема продуктов в понятные для вас меры.</p>
						</div>
					</li>
					<li>
						<div class="img"><a href=""><img src="/images/services/service_img_10.png"></a></div>
						<div class="text">
							<div class="item-title"><a href="">Когда уходить в декрет?</a></div>
							<p>Сервис для перевода веса и объема продуктов в понятные для вас меры.</p>
						</div>
					</li>
				</ul>
			</div>
			<div class="section-banner-pregnancy-test">
				<a href="" class="btn-yellow btn-big">ПРОЙТИ ТЕСТ</a>
			</div>
		</div>      
		<div class="section section__gray">
			<div class="section_hold">
				<div class="masonry-news-list  margin-l20 clearfix">
					<ul>
						<li class="masonry-news-list_item margin-b0">
							<div class="online-status">На сайте</div>
							<div class="user-info-big clearfix">
								<div class="user-info clearfix">
									<a class="ava female"><img alt="" src="http://img.happy-giraffe.ru/avatars/10450/ava/5fec5b9b0212f2f55da541aeae22b9ec.JPG"></a>
									<div class="details">
										<a class="username" href="">Викториал Богоявленский</a>
										<div class="date">35 лет (22 января)</div>
										<div class="location"><div title="Украина" class="flag flag-ua"></div>Луцк</div>
									</div>
								</div>
							</div>
							<div class="user-fast-buttons">
								<a class="add-friend" href=""><span class="tip">Пригласить в друзья</span></a>
								<a class="new-message" href=""><span class="tip">Написать сообщение</span></a>
								<a href="">Анкета</a>
								<a href="">Блог</a><sup class="count">9999</sup>
								<a href="">Фото</a><sup class="count">9999</sup>
							</div>
							<div class="find-friend-famyli">
										<div class="textalign-c clearfix">
											<img src="/images/user-family.png" alt="">
										</div>
										<ul class="find-friend-famyli-list">
											<li>
												<div class="img"><img alt="" src="/images/example/w41-h49-1.jpg"></div>
												<span class="yellow">Жена</span> <br>
												<span>Елизаветушка</span>
											</li>
											<li>
												<div class="img"><img alt="" src="/images/example/w52-h34-1.jpg"></div>
												<span class="yellow">Дочь</span> <br>
												<span>Евгения</span> <br>
												<span class="yellow">4 года</span>
											</li>
											<li>
												<div class="img"><img alt="" src="/images/example/w41-h49-1.jpg"></div>
												<span class="yellow">Дочь</span> <br>
												<span>Евгения</span> <br>
												<span class="yellow">3 года</span>
											</li>
											<li>
												<div class="img"><img alt="" src="/images/example/w41-h49-1.jpg"></div>
												<span class="yellow">Дочь</span> <br>
												<span>Евгения</span> <br>
												<span class="yellow">2 года 12 мес.</span>
											</li>
											
											<li>
												<div class="img"><img alt="" src="/images/example/w52-h34-1.jpg"></div>
												<span class="yellow">Дочь</span> <br>
												<span>Евгения</span> <br>
												<span class="yellow"> 2 мес.</span>
											</li>
										</ul>
									</div>
						</li>
						
						<li class="masonry-news-list_item margin-b0">
							<div class="user-info-big clearfix">
								<div class="user-info clearfix">
									<a class="ava female"><img alt="" src="http://img.happy-giraffe.ru/avatars/56/ava/e270c4d21ee53c19d09a1ff3ff6ee473.jpg"></a>
									<div class="details">
										<a class="username" href="">Саша</a>
										<div class="date">35 лет (22 января)</div>
										<div class="location"><div title="Россия" class="flag flag-ru"></div>Гаврилов-Ям Ярославская обл.</div>
									</div>
								</div>
							</div>
							<div class="user-fast-buttons">
								<a class="add-friend" href=""><span class="tip">Пригласить в друзья</span></a>
								<a class="new-message" href=""><span class="tip">Написать сообщение</span></a>
								<a href="">Анкета</a>
								<a href="">Блог</a><sup class="count">9999</sup>
								<a href="">Фото</a><sup class="count">999</sup>
							</div>
							<div class="find-friend-famyli">
										<div class="textalign-c clearfix">
											<img src="/images/user-family.png" alt="">
										</div>
										<ul class="find-friend-famyli-list">
											<li>
												<div class="img"><img alt="" src="/images/example/w41-h49-1.jpg"></div>
												<span class="yellow">Жена</span> <br>
												<span>Елизавета</span>
											</li>
											<li>
												<div class="img ico-child ico-child__boy-5"></div>
												<span class="yellow">Сын</span> <br>
												<span>Саша</span> <br>
												<span class="yellow">5 лет</span>
											</li><li>
												<div class="img ico-child ico-child__girl-5"></div>
												<span class="yellow">Дочь</span> <br>
												<span>Евгения</span> <br>
												<span class="yellow">4 года</span>
											</li>
											<li>
												<div class="img ico-child ico-child__boy-wait"></div>
												<span>Ждем</span> <br>
												<span class="yellow">мальчика</span> <br>
												<span class="blue-text">26 неделя</span>
											</li>
											<li>
												<div class="img ico-child ico-child__girl-wait"></div>
												<span>Ждем</span> <br>
												<span class="yellow">Девочку</span> <br>
												<span class="pink-text">26 неделя</span>
											</li>
										</ul>
									</div>
						</li>
						
						<li class="masonry-news-list_item margin-b0">
							<div class="online-status">На сайте</div>
							<div class="user-info-big clearfix">
								<div class="user-info clearfix">
									<a class="ava female"><img alt="" src="http://img.happy-giraffe.ru/avatars/10450/ava/5fec5b9b0212f2f55da541aeae22b9ec.JPG"></a>
									<div class="details">
										<a class="username" href="">Викториал Богоявленский</a>
										<div class="date">35 лет (22 января)</div>
										<div class="location"><div title="Россия" class="flag flag-ru"></div>Гаврилов-Ям Ярославская обл.</div>
									</div>
								</div>
							</div>
							<div class="user-fast-buttons">
								<a class="add-friend" href=""><span class="tip">Пригласить в друзья</span></a>
								<a class="new-message" href=""><span class="tip">Написать сообщение</span></a>
								<a href="">Анкета</a>
								<a href="">Блог</a><sup class="count">9</sup>
								<a href="">Фото</a><sup class="count">99</sup>
							</div>
							<div class="find-friend-famyli">
										<div class="textalign-c clearfix">
											<img src="/images/user-family.png" alt="">
										</div>
										<ul class="find-friend-famyli-list">
											<li>
												<div class="img"><img alt="" src="/images/example/w52-h34-1.jpg"></div>
												<span class="yellow">Жена</span> <br>
												<span>Светлана</span>
											</li>
											<li>
												<div class="img">
												<img src="http://img.happy-giraffe.ru/thumbs/66x66/83/2d77cb16aa563469aeb8af25ad69e436.JPG" alt="Настюня"></div>
												<span class="yellow">Дочь</span> <br>
												<span>Евгения</span> <br>
												<span class="yellow">3 мес.</span>
											</li>
											<li>
												<div class="img"><img alt="" src="/images/example/w41-h49-1.jpg"></div>
												<span class="yellow">Дочь</span> <br>
												<span>Евгения</span> <br>
												<span class="yellow">3 мес.</span>
											</li>
										</ul>
									</div>
						</li>

						<li class="masonry-news-list_item margin-b0">
							<div class="online-status">На сайте</div>
							<div class="user-info-big clearfix">
								<div class="user-info clearfix">
									<a class="ava female"><img alt="" src="http://img.happy-giraffe.ru/avatars/10450/ava/5fec5b9b0212f2f55da541aeae22b9ec.JPG"></a>
									<div class="details">
										<a class="username" href="">Викториал Богоявленский</a>
										<div class="date">35 лет (22 января)</div>
										<div class="location"><div title="Россия" class="flag flag-ru"></div>Гаврилов-Ям Ярославская обл.</div>
									</div>
								</div>
							</div>
							<div class="user-fast-buttons">
								<a class="add-friend" href=""><span class="tip">Пригласить в друзья</span></a>
								<a class="new-message" href=""><span class="tip">Написать сообщение</span></a>
								<a href="">Анкета</a>
								<a href="">Блог</a>
								<a href="">Фото</a>
							</div>
							<div class="find-friend-famyli">
										<div class="textalign-c clearfix">
											<img src="/images/user-family.png" alt="">
										</div>
										<ul class="find-friend-famyli-list">
											<li>
												<div class="img"><img alt="" src="http://img.happy-giraffe.ru/thumbs/66x66/15551/3f740600a7c4a2af164527f616b2600f.JPG"></div>
												<span class="yellow">Жена</span> <br>
												<span>Елизаветушка</span>
											</li>
											<li>
												<div class="img"><img alt="" src="http://img.happy-giraffe.ru/thumbs/66x66/15551/3f740600a7c4a2af164527f616b2600f.JPG"></div>
												<span class="yellow">Дочь</span> <br>
												<span>Евгения</span> <br>
												<span class="yellow">3 мес.</span>
											</li>
											<li>
												<div class="img"><img alt="" src="http://img.happy-giraffe.ru/thumbs/66x66/15551/3f740600a7c4a2af164527f616b2600f.JPG"></div>
												<span class="yellow">Дочь</span> <br>
												<span>Евгения</span> <br>
												<span class="yellow">3 мес.</span>
											</li>
										</ul>
									</div>
						</li>
					</ul>
				</div>
				<div class="ava-small-list clearfix">
					<ul>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/20909/small/e13fab92d1a406a9ffca8881a6afa24b.jpg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15292/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/20909/small/e13fab92d1a406a9ffca8881a6afa24b.jpg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/20909/small/e13fab92d1a406a9ffca8881a6afa24b.jpg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/20909/small/e13fab92d1a406a9ffca8881a6afa24b.jpg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/20909/small/e13fab92d1a406a9ffca8881a6afa24b.jpg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/20909/small/e13fab92d1a406a9ffca8881a6afa24b.jpg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15292/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG"></a></li>
						<li class="ava-small-list_li"><span class="ava-small-list_count">еще 4 577</span></li>
					</ul>
				</div>
			</div>
			<div class="section_overlay">
				<div class="section-join">
					<div class="section-join_desc">
						<div class="section-join_t">Мы ждем ребенка. </div>
						<div class="section-join_tx">Нас тут много!</div>
					</div>
					<div class="section-join_btn btn-green btn-h55">Присоединяйтесь!</div>
				</div>
			</div>
		</div>
		<div class="section section__gray">
			<div class="section_hold">
				<div class="section_t-hold">
					<a href="" class="float-r"><i class="ico-friends-small"></i>Найти еще</a>
					<h2>Наши мамы и папы</h2>
				</div>
				<div class="masonry-news-list  margin-l20 margin-b0 clearfix">
					<ul class="js-isotop">
						<li class="masonry-news-list_item">
							<div class="online-status">На сайте</div>
							<div class="user-info-big clearfix">
								<div class="user-info clearfix">
									<a class="ava female"><img alt="" src="http://img.happy-giraffe.ru/avatars/10450/ava/5fec5b9b0212f2f55da541aeae22b9ec.JPG"></a>
									<div class="details">
										<a class="username" href="">Викториал Богоявленский</a>
										<div class="date">35 лет (22 января)</div>
										<div class="location"><div title="Украина" class="flag flag-ua"></div>Луцк</div>
									</div>
								</div>
							</div>
							<div class="user-fast-buttons">
								<a class="add-friend" href=""><span class="tip">Пригласить в друзья</span></a>
								<a class="new-message" href=""><span class="tip">Написать сообщение</span></a>
								<a href="">Анкета</a>
								<a href="">Блог</a><sup class="count">9999</sup>
								<a href="">Фото</a><sup class="count">9999</sup>
							</div>
							<div class="find-friend-famyli">
										<div class="textalign-c clearfix">
											<img src="/images/user-family.png" alt="">
										</div>
										<ul class="find-friend-famyli-list">
											<li>
												<div class="img"><img alt="" src="/images/example/w41-h49-1.jpg"></div>
												<span class="yellow">Жена</span> <br>
												<span>Елизаветушка</span>
											</li>
											<li>
												<div class="img"><img alt="" src="/images/example/w52-h34-1.jpg"></div>
												<span class="yellow">Дочь</span> <br>
												<span>Евгения</span> <br>
												<span class="yellow">4 года</span>
											</li>
											<li>
												<div class="img"><img alt="" src="/images/example/w41-h49-1.jpg"></div>
												<span class="yellow">Дочь</span> <br>
												<span>Евгения</span> <br>
												<span class="yellow">3 года</span>
											</li>
											<li>
												<div class="img"><img alt="" src="/images/example/w41-h49-1.jpg"></div>
												<span class="yellow">Дочь</span> <br>
												<span>Евгения</span> <br>
												<span class="yellow">2 года 12 мес.</span>
											</li>
											
											<li>
												<div class="img"><img alt="" src="/images/example/w52-h34-1.jpg"></div>
												<span class="yellow">Дочь</span> <br>
												<span>Евгения</span> <br>
												<span class="yellow"> 2 мес.</span>
											</li>
										</ul>
									</div>
						</li>
						
						<li class="masonry-news-list_item">
							<div class="user-info-big clearfix">
								<div class="user-info clearfix">
									<a class="ava female"><img alt="" src="http://img.happy-giraffe.ru/avatars/56/ava/e270c4d21ee53c19d09a1ff3ff6ee473.jpg"></a>
									<div class="details">
										<a class="username" href="">Саша</a>
										<div class="date">35 лет (22 января)</div>
										<div class="location"><div title="Россия" class="flag flag-ru"></div>Гаврилов-Ям Ярославская обл.</div>
									</div>
								</div>
							</div>
							<div class="user-fast-buttons">
								<a class="add-friend" href=""><span class="tip">Пригласить в друзья</span></a>
								<a class="new-message" href=""><span class="tip">Написать сообщение</span></a>
								<a href="">Анкета</a>
								<a href="">Блог</a><sup class="count">9999</sup>
								<a href="">Фото</a><sup class="count">999</sup>
							</div>
							<div class="find-friend-famyli">
										<div class="textalign-c clearfix">
											<img src="/images/user-family.png" alt="">
										</div>
										<ul class="find-friend-famyli-list">
											<li>
												<div class="img"><img alt="" src="/images/example/w41-h49-1.jpg"></div>
												<span class="yellow">Жена</span> <br>
												<span>Елизавета</span>
											</li>
											<li>
												<div class="img ico-child ico-child__boy-5"></div>
												<span class="yellow">Сын</span> <br>
												<span>Саша</span> <br>
												<span class="yellow">5 лет</span>
											</li><li>
												<div class="img ico-child ico-child__girl-5"></div>
												<span class="yellow">Дочь</span> <br>
												<span>Евгения</span> <br>
												<span class="yellow">4 года</span>
											</li>
											<li>
												<div class="img ico-child ico-child__boy-wait"></div>
												<span>Ждем</span> <br>
												<span class="yellow">мальчика</span> <br>
												<span class="blue-text">26 неделя</span>
											</li>
											<li>
												<div class="img ico-child ico-child__girl-wait"></div>
												<span>Ждем</span> <br>
												<span class="yellow">Девочку</span> <br>
												<span class="pink-text">26 неделя</span>
											</li>
										</ul>
									</div>
						</li>
						
						<li class="masonry-news-list_item">
							<div class="online-status">На сайте</div>
							<div class="user-info-big clearfix">
								<div class="user-info clearfix">
									<a class="ava female"><img alt="" src="http://img.happy-giraffe.ru/avatars/10450/ava/5fec5b9b0212f2f55da541aeae22b9ec.JPG"></a>
									<div class="details">
										<a class="username" href="">Викториал Богоявленский</a>
										<div class="date">35 лет (22 января)</div>
										<div class="location"><div title="Россия" class="flag flag-ru"></div>Гаврилов-Ям Ярославская обл.</div>
									</div>
								</div>
							</div>
							<div class="user-fast-buttons">
								<a class="add-friend" href=""><span class="tip">Пригласить в друзья</span></a>
								<a class="new-message" href=""><span class="tip">Написать сообщение</span></a>
								<a href="">Анкета</a>
								<a href="">Блог</a><sup class="count">9</sup>
								<a href="">Фото</a><sup class="count">99</sup>
							</div>
							<div class="find-friend-famyli">
										<div class="textalign-c clearfix">
											<img src="/images/user-family.png" alt="">
										</div>
										<ul class="find-friend-famyli-list">
											<li>
												<div class="img"><img alt="" src="/images/example/w52-h34-1.jpg"></div>
												<span class="yellow">Жена</span> <br>
												<span>Светлана</span>
											</li>
											<li>
												<div class="img">
												<img src="http://img.happy-giraffe.ru/thumbs/66x66/83/2d77cb16aa563469aeb8af25ad69e436.JPG" alt="Настюня"></div>
												<span class="yellow">Дочь</span> <br>
												<span>Евгения</span> <br>
												<span class="yellow">3 мес.</span>
											</li>
											<li>
												<div class="img"><img alt="" src="/images/example/w41-h49-1.jpg"></div>
												<span class="yellow">Дочь</span> <br>
												<span>Евгения</span> <br>
												<span class="yellow">3 мес.</span>
											</li>
										</ul>
									</div>
						</li>

						<li class="masonry-news-list_item">
							<div class="online-status">На сайте</div>
							<div class="user-info-big clearfix">
								<div class="user-info clearfix">
									<a class="ava female"><img alt="" src="http://img.happy-giraffe.ru/avatars/10450/ava/5fec5b9b0212f2f55da541aeae22b9ec.JPG"></a>
									<div class="details">
										<a class="username" href="">Викториал Богоявленский</a>
										<div class="date">35 лет (22 января)</div>
										<div class="location"><div title="Россия" class="flag flag-ru"></div>Гаврилов-Ям Ярославская обл.</div>
									</div>
								</div>
							</div>
							<div class="user-fast-buttons">
								<a class="add-friend" href=""><span class="tip">Пригласить в друзья</span></a>
								<a class="new-message" href=""><span class="tip">Написать сообщение</span></a>
								<a href="">Анкета</a>
								<a href="">Блог</a>
								<a href="">Фото</a>
							</div>
							<div class="find-friend-famyli">
										<div class="textalign-c clearfix">
											<img src="/images/user-family.png" alt="">
										</div>
										<ul class="find-friend-famyli-list">
											<li>
												<div class="img"><img alt="" src="http://img.happy-giraffe.ru/thumbs/66x66/15551/3f740600a7c4a2af164527f616b2600f.JPG"></div>
												<span class="yellow">Жена</span> <br>
												<span>Елизаветушка</span>
											</li>
											<li>
												<div class="img"><img alt="" src="http://img.happy-giraffe.ru/thumbs/66x66/15551/3f740600a7c4a2af164527f616b2600f.JPG"></div>
												<span class="yellow">Дочь</span> <br>
												<span>Евгения</span> <br>
												<span class="yellow">3 мес.</span>
											</li>
											<li>
												<div class="img"><img alt="" src="http://img.happy-giraffe.ru/thumbs/66x66/15551/3f740600a7c4a2af164527f616b2600f.JPG"></div>
												<span class="yellow">Дочь</span> <br>
												<span>Евгения</span> <br>
												<span class="yellow">3 мес.</span>
											</li>
										</ul>
									</div>
						</li>
						
						<li class="masonry-news-list_item">
							<div class="user-info-big clearfix">
								<div class="user-info clearfix">
									<a class="ava female"><img alt="" src="http://img.happy-giraffe.ru/avatars/56/ava/e270c4d21ee53c19d09a1ff3ff6ee473.jpg"></a>
									<div class="details">
										<a class="username" href="">Саша</a>
										<div class="date">35 лет (22 января)</div>
										<div class="location"><div title="Россия" class="flag flag-ru"></div>Гаврилов-Ям Ярославская обл.</div>
									</div>
								</div>
							</div>
							<div class="user-fast-buttons">
								<a class="add-friend" href=""><span class="tip">Пригласить в друзья</span></a>
								<a class="new-message" href=""><span class="tip">Написать сообщение</span></a>
								<a href="">Анкета</a>
								<a href="">Блог</a><sup class="count">9999</sup>
								<a href="">Фото</a><sup class="count">999</sup>
							</div>
							<div class="find-friend-famyli">
										<div class="textalign-c clearfix">
											<img src="/images/user-family.png" alt="">
										</div>
										<ul class="find-friend-famyli-list">
											<li>
												<div class="img"><img alt="" src="/images/example/w41-h49-1.jpg"></div>
												<span class="yellow">Жена</span> <br>
												<span>Елизавета</span>
											</li>
											<li>
												<div class="img ico-child ico-child__boy-5"></div>
												<span class="yellow">Сын</span> <br>
												<span>Саша</span> <br>
												<span class="yellow">5 лет</span>
											</li><li>
												<div class="img ico-child ico-child__girl-5"></div>
												<span class="yellow">Дочь</span> <br>
												<span>Евгения</span> <br>
												<span class="yellow">4 года</span>
											</li>
											<li>
												<div class="img ico-child ico-child__boy-wait"></div>
												<span>Ждем</span> <br>
												<span class="yellow">мальчика</span> <br>
												<span class="blue-text">26 неделя</span>
											</li>
											<li>
												<div class="img ico-child ico-child__girl-wait"></div>
												<span>Ждем</span> <br>
												<span class="yellow">Девочку</span> <br>
												<span class="pink-text">26 неделя</span>
											</li>
										</ul>
									</div>
						</li>
						
						<li class="masonry-news-list_item">
							<div class="online-status">На сайте</div>
							<div class="user-info-big clearfix">
								<div class="user-info clearfix">
									<a class="ava female"><img alt="" src="http://img.happy-giraffe.ru/avatars/10450/ava/5fec5b9b0212f2f55da541aeae22b9ec.JPG"></a>
									<div class="details">
										<a class="username" href="">Викториал Богоявленский</a>
										<div class="date">35 лет (22 января)</div>
										<div class="location"><div title="Россия" class="flag flag-ru"></div>Гаврилов-Ям Ярославская обл.</div>
									</div>
								</div>
							</div>
							<div class="user-fast-buttons">
								<a class="add-friend" href=""><span class="tip">Пригласить в друзья</span></a>
								<a class="new-message" href=""><span class="tip">Написать сообщение</span></a>
								<a href="">Анкета</a>
								<a href="">Блог</a><sup class="count">9</sup>
								<a href="">Фото</a><sup class="count">99</sup>
							</div>
							<div class="find-friend-famyli">
										<div class="textalign-c clearfix">
											<img src="/images/user-family.png" alt="">
										</div>
										<ul class="find-friend-famyli-list">
											<li>
												<div class="img"><img alt="" src="/images/example/w52-h34-1.jpg"></div>
												<span class="yellow">Жена</span> <br>
												<span>Светлана</span>
											</li>
											<li>
												<div class="img">
												<img src="http://img.happy-giraffe.ru/thumbs/66x66/83/2d77cb16aa563469aeb8af25ad69e436.JPG" alt="Настюня"></div>
												<span class="yellow">Дочь</span> <br>
												<span>Евгения</span> <br>
												<span class="yellow">3 мес.</span>
											</li>
											<li>
												<div class="img"><img alt="" src="/images/example/w41-h49-1.jpg"></div>
												<span class="yellow">Дочь</span> <br>
												<span>Евгения</span> <br>
												<span class="yellow">3 мес.</span>
											</li>
										</ul>
									</div>
						</li>

						<li class="masonry-news-list_item">
							<div class="online-status">На сайте</div>
							<div class="user-info-big clearfix">
								<div class="user-info clearfix">
									<a class="ava female"><img alt="" src="http://img.happy-giraffe.ru/avatars/10450/ava/5fec5b9b0212f2f55da541aeae22b9ec.JPG"></a>
									<div class="details">
										<a class="username" href="">Викториал Богоявленский</a>
										<div class="date">35 лет (22 января)</div>
										<div class="location"><div title="Россия" class="flag flag-ru"></div>Гаврилов-Ям Ярославская обл.</div>
									</div>
								</div>
							</div>
							<div class="user-fast-buttons">
								<a class="add-friend" href=""><span class="tip">Пригласить в друзья</span></a>
								<a class="new-message" href=""><span class="tip">Написать сообщение</span></a>
								<a href="">Анкета</a>
								<a href="">Блог</a>
								<a href="">Фото</a>
							</div>
							<div class="find-friend-famyli">
										<div class="textalign-c clearfix">
											<img src="/images/user-family.png" alt="">
										</div>
										<ul class="find-friend-famyli-list">
											<li>
												<div class="img"><img alt="" src="http://img.happy-giraffe.ru/thumbs/66x66/15551/3f740600a7c4a2af164527f616b2600f.JPG"></div>
												<span class="yellow">Жена</span> <br>
												<span>Елизаветушка</span>
											</li>
											<li>
												<div class="img"><img alt="" src="http://img.happy-giraffe.ru/thumbs/66x66/15551/3f740600a7c4a2af164527f616b2600f.JPG"></div>
												<span class="yellow">Дочь</span> <br>
												<span>Евгения</span> <br>
												<span class="yellow">3 мес.</span>
											</li>
											<li>
												<div class="img"><img alt="" src="http://img.happy-giraffe.ru/thumbs/66x66/15551/3f740600a7c4a2af164527f616b2600f.JPG"></div>
												<span class="yellow">Дочь</span> <br>
												<span>Евгения</span> <br>
												<span class="yellow">3 мес.</span>
											</li>
										</ul>
									</div>
						</li>
						
						<li class="masonry-news-list_item">
							<div class="user-info-big clearfix">
								<div class="user-info clearfix">
									<a class="ava female"><img alt="" src="http://img.happy-giraffe.ru/avatars/56/ava/e270c4d21ee53c19d09a1ff3ff6ee473.jpg"></a>
									<div class="details">
										<a class="username" href="">Саша</a>
										<div class="date">35 лет (22 января)</div>
										<div class="location"><div title="Россия" class="flag flag-ru"></div>Гаврилов-Ям Ярославская обл.</div>
									</div>
								</div>
							</div>
							<div class="user-fast-buttons">
								<a class="add-friend" href=""><span class="tip">Пригласить в друзья</span></a>
								<a class="new-message" href=""><span class="tip">Написать сообщение</span></a>
								<a href="">Анкета</a>
								<a href="">Блог</a><sup class="count">9999</sup>
								<a href="">Фото</a><sup class="count">999</sup>
							</div>
							<div class="find-friend-famyli">
										<div class="textalign-c clearfix">
											<img src="/images/user-family.png" alt="">
										</div>
										<ul class="find-friend-famyli-list">
											<li>
												<div class="img"><img alt="" src="/images/example/w41-h49-1.jpg"></div>
												<span class="yellow">Жена</span> <br>
												<span>Елизавета</span>
											</li>
											<li>
												<div class="img ico-child ico-child__boy-5"></div>
												<span class="yellow">Сын</span> <br>
												<span>Саша</span> <br>
												<span class="yellow">5 лет</span>
											</li><li>
												<div class="img ico-child ico-child__girl-5"></div>
												<span class="yellow">Дочь</span> <br>
												<span>Евгения</span> <br>
												<span class="yellow">4 года</span>
											</li>
											<li>
												<div class="img ico-child ico-child__boy-wait"></div>
												<span>Ждем</span> <br>
												<span class="yellow">мальчика</span> <br>
												<span class="blue-text">26 неделя</span>
											</li>
											<li>
												<div class="img ico-child ico-child__girl-wait"></div>
												<span>Ждем</span> <br>
												<span class="yellow">Девочку</span> <br>
												<span class="pink-text">26 неделя</span>
											</li>
										</ul>
									</div>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="footer-push"></div>
		
	</div>
	 <?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/footer.php'; ?>
</div>
</body>
</html>
