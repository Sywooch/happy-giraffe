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
		<!-- Вставка секции в шапке страницы -->
		<?php $headerSection = '
		<a class="layout-header-section_a" href="">
			<img alt="" src="/images/section/cook/layout-header-section_img.jpg" class="layout-header-section_img">
			<span class="layout-header-section_text">Кулинария</span>
		</a>
		'?>
		<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/layout-header.php'; ?>
		
			<div class="section section__sand">
				<div class="section_hold">
					<div class="box-two-transp">
						<div class="box-two-transp_hold">
							<div class="cook_links-menu clearfix">
								<a href="" class="cook_links-menu_a">
									<img src="/images/section/cook/ico-new-year-cook.png" alt="" class="cook_links-menu_img">
									<span class="cook_links-menu_tx">Новогодние рецепты 2013</span>
								</a>
								<a href="" class="cook_links-menu_a">
									<img src="/images/section/cook/ico-christmas.png" alt="" class="cook_links-menu_img">
									<span class="cook_links-menu_tx">Рождественский пост</span>
								</a>
							</div>
						</div>
					</div>
					<div class="content-cols clearfix">
						<div class="col-1">
							<div class="section-menu">
								<div class="section-menu-top">
									<div class="section-menu_t">Тысячи рецептов <div class="section-menu_t-small">от наших пользователей</div></div>
									<div class="section-menu_search clearfix">
										<input type="text" class="section-menu_search-itx" placeholder="Поиск из 12 687 рецептов">
										<input type="submit" value="" class="section-menu_search-submit">
									</div>
								</div>
							</div>
							
							<div class="recipe-categories recipe-categories__section">
								<ul>
									<li>
										<a href="" class="cook-cat">
											<span class="cook-cat-holder">
												<i class="icon-cook-cat icon-recipe-0 active"></i>
											</span>
											<span class="cook-cat-frame">
												<span>Все рецепты</span>
												<span class="count">12 582</span>
											</span>
										</a>
									</li>
									<li class="">
										<a href="" class="cook-cat">
											<span class="cook-cat-holder">
												<i class="icon-cook-cat icon-recipe-1 active"></i>
											</span>
											<span class="cook-cat-frame">
												<span>Первые блюда</span>
												<span class="count">582</span>
											</span>
										</a>
									</li>
									<li>
										<a href="" class="cook-cat">
											<span class="cook-cat-holder">
												<i class="icon-cook-cat icon-recipe-2 active"></i>
											</span>
											<span class="cook-cat-frame">
												<span>Вторые блюда</span>
												<span class="count">582</span>
											</span>
										</a>
									</li>
									<li>
										<a href="" class="cook-cat">
											<span class="cook-cat-holder">
												<i class="icon-cook-cat icon-recipe-3 active"></i>
											</span>
											<span class="cook-cat-frame">
												<span>Салаты</span>
												<span class="count">12 555 582</span>
											</span>
										</a>
									</li>
									<li>
										<a href="" class="cook-cat">
											<span class="cook-cat-holder">
												<i class="icon-cook-cat icon-recipe-4 active"></i>
											</span>
											<span class="cook-cat-frame">
												<span>Закуски и&nbsp;бутерброды</span>
												<span class="count">12 582</span>
											</span>
										</a>									
									</li>
									<li>
										<a href="" class="cook-cat">
											<span class="cook-cat-holder">
												<i class="icon-cook-cat icon-recipe-5 active"></i>
											</span>
											<span class="cook-cat-frame">
												<span>Сладкая выпечка</span>
												<span class="count">12 582</span>
											</span>
										</a>									
									</li>
									<li>
										<a href="" class="cook-cat">
											<span class="cook-cat-holder">
												<i class="icon-cook-cat icon-recipe-6 active"></i>
											</span>
											<span class="cook-cat-frame">
												<span>Несладкая выпечка</span>
												<span class="count">12 582</span>
											</span>
										</a>									
									</li>
									<li>
										<a href="" class="cook-cat">
											<span class="cook-cat-holder">
												<i class="icon-cook-cat icon-recipe-7 active"></i>
											</span>
											<span class="cook-cat-frame">
												<span>Торты и&nbsp;пирожные</span>
												<span class="count">12 582</span>
											</span>
										</a>									
									</li>
									<li>
										<a href="" class="cook-cat">
											<span class="cook-cat-holder">
												<i class="icon-cook-cat icon-recipe-8 active"></i>
											</span>
											<span class="cook-cat-frame">
												<span>Десерты</span>
												<span class="count">122</span>
											</span>
										</a>									
									</li>
									<li>
										<a href="" class="cook-cat">
											<span class="cook-cat-holder">
												<i class="icon-cook-cat icon-recipe-9 active"></i>
											</span>
											<span class="cook-cat-frame">
												<span>Напитки</span>
												<span class="count">2</span>
											</span>
										</a>									
									</li>
									<li>
										<a href="" class="cook-cat">
											<span class="cook-cat-holder">
												<i class="icon-cook-cat icon-recipe-10 active"></i>
											</span>
											<span class="cook-cat-frame">
												<span>Соусы и&nbsp;кремы</span>
												<span class="count">2</span>
											</span>
										</a>									
									</li>
									<li>
										<a href="" class="cook-cat">
											<span class="cook-cat-holder">
												<i class="icon-cook-cat icon-recipe-11 active"></i>
											</span>
											<span class="cook-cat-frame">
												<span>Консервация</span>
												<span class="count">6 662</span>
											</span>
										</a>									
									</li>
								</ul>
							</div>
						
						</div>
						<div class="col-23-big">
							<div class="section-cnt">
		<script>
		$(function() {
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
								<li class="masonry-news-list_item">
									<h3 class="masonry-news-list_title">
										<a href="">Волшебная азбука</a>
									</h3>
									<div class="masonry-news-list_meta-info clearfix">
										
										<div class="meta">
											<div class="views"><span class="icon" href="#"></span> <span>265</span></div>
											<div class="comments">
												<a class="icon" href="#"></a>
												<a href="">152</a>
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
										<ul class="masonry-news-list_img-list clearfix">
											<li><a href=""><img src="/images/example/w64-h61-1.jpg" alt="" /></a></li>
											<li><a href=""><img src="/images/example/w64-h61-2.jpg" alt="" /></a></li>
											<li><a href=""><img src="/images/example/w64-h61-2.jpg" alt="" /></a></li>
											<li><a href=""><img src="/images/example/w64-h61-1.jpg" alt="" /></a></li>
											<li><a href=""><img src="/images/example/w64-h61-2.jpg" alt="" /></a></li>
											<li><a href=""><img src="/images/example/w64-h61-1.jpg" alt="" /></a></li>
											<li><a href=""><img src="/images/example/w64-h61-2.jpg" alt="" /></a></li>
											<li><a href=""><img src="/images/example/w64-h61-1.jpg" alt="" /></a></li>
											<li><a href=""><img src="/images/example/w64-h61-2.jpg" alt="" /></a></li>
										</ul>
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
							</ul>
								</div>
								<div class="clearfix textalign-c">
									<a href="" class="btn-green_medium__corner-r">Все рецепты</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<div class="layout-content margin-b0 clearfix">
			<div class="services-list">
				<div class="services-list_t">Полезные сервисы. <span class="color-green"> Для кулинара!</span></div>
				<ul>
					<li>
						<div class="img"><a href=""><img src="/images/services/service_img_11.png"></a></div>
						<div class="text">
							<div class="item-title"><a href="">Рецепты для мультиварок</a></div>
							<p>Стали обладательницей мультиварки? Выбирайте подходящий рецепт здесь.</p>
						</div>
					</li>
					<li>
						<div class="img"><a href=""><img src="/images/services/service_img_12.png"></a></div>
						<div class="text">
							<div class="item-title"><a href="">Калькулятор мер</a></div>
							<p>Сервис для перевода веса и объема продуктов в понятные для вас меры.</p>
						</div>
					</li>
					<li>
						<div class="img"><a href=""><img src="/images/services/service_img_13.png"></a></div>
						<div class="text">
							<div class="item-title"><a href="">Счетчик калорий</a></div>
							<p>Узнавайте сколько калорий, а также белков, жиров и углеводов в любых </p>
						</div>
					</li>
					<li>
						<div class="img"><a href=""><img src="/images/services/service_img_19.png"></a></div>
						<div class="text">
							<div class="item-title"><a href="">Офррмление блюд</a></div>
							<p>Стали обладательницей мультиварки? Выбирайте подходящий рецепт здесь.</p>
						</div>
					</li>
					<li>
						<div class="img"><a href=""><img src="/images/services/service_img_20.png"></a></div>
						<div class="text">
							<div class="item-title"><a href="">Приправы и специи</a></div>
							<p>Сервис для перевода веса и объема продуктов в понятные для вас меры.</p>
						</div>
					</li>
					<li>
						<div class="img"><a href=""><img src="/images/services/service_img_21.png"></a></div>
						<div class="text">
							<div class="item-title"><a href="">Как выбирать продукты</a></div>
							<p>Узнавайте сколько калорий, а также белков, жиров и углеводов в любых </p>
						</div>
					</li>
				</ul>
			</div>
			<div class="b-multivarka">
				<div class="b-multivarka_hold clearfix">
					<div class="b-multivarka_logo">
						<div class="b-multivarka_logo-tx">
							<span class="b-multivarka_logo-count">3 000</span>
							рецептов для мультиварок
						</div>
					</div>
					<div class="b-multivarka_ul">
						<ul>
							<li class="b-multivarka_li">
								<a href="" class="b-multivarka_li_a">
									<img class="b-multivarka_li_img" src="/images/cook_more_img_01.jpg" alt="" height="105" width="120">
									<span class="b-multivarka_li_tx">Торт песочный с орехами</span>
								</a>
							</li>
							<li class="b-multivarka_li">
								<a href="" class="b-multivarka_li_a">
									<img class="b-multivarka_li_img" src="/images/cook_more_img_01.jpg" alt="" height="105" width="120">
									<span class="b-multivarka_li_tx">Торт песочный с орехами, черникой и клубникой</span>
								</a>
							</li>
							<li class="b-multivarka_li">
								<a href="" class="b-multivarka_li_a">
									<img class="b-multivarka_li_img" src="/images/cook_more_img_01.jpg" alt="" height="105" width="120">
									<span class="b-multivarka_li_tx">Умный рулет</span>
								</a>
							</li>
							<li class="b-multivarka_li">
								<a href="" class="b-multivarka_li_a">
									<img class="b-multivarka_li_img" height="105" width="120" src="/images/cook_recipe_img_01.jpg">
									<span class="b-multivarka_li_tx">Умный рулет</span>
								</a>
							</li>
							<li class="b-multivarka_li">
								<a href="" class="b-multivarka_li_a">
									<img class="b-multivarka_li_img" src="/images/cook_more_img_01.jpg" alt="" height="105" width="120">
									<span class="b-multivarka_li_tx">Торт песочный с орехами, черникой и клубникой</span>
								</a>
							</li>
							<li class="b-multivarka_li">
								<a href="" class="b-multivarka_li_btn">Смотреть все рецепты</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="hr-notches"></div>
			<h2>О чем общаются кулинары?</h2>
			<div class="masonry-news-list">
				<ul>
					<li class="masonry-news-list_item">
						<div class="masonry-news-list_comment top">
							<div class="masonry-news-list_comment-text">
								проблема в том, что на 2006-ой год игры еще толком не было
							</div>
							<div class="masonry-news-list_meta-info clearfix">
								<div class="user-info">
									<a class="ava female small"><img alt="" src="http://img.happy-giraffe.ru/avatars/19372/small/21fd8c8f29c5a289df17938cb2f20e5b.jpg"></a>
									<div class="details">
										<a class="username" href="">Александр</a>
										<span class="date">Сегодня 13:25</span>
									</div>
								</div>
							</div>
						</div>
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
							<p>Роды — отправная точка для самых важных изменений и судьбоносных... <a href="" class="all">Читать</a></p>
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
							<p>Роды — отправная точка для самых важных изменений и судьбоносных... <a href="" class="all">Читать</a></p>
						</div>
					</li>
					
					<li class="masonry-news-list_item">
						<div class="masonry-news-list_comment top">
							<div class="masonry-news-list_comment-text">
								<a href="">проблема в том, что на 2006-ой год игры еще толком не было...</a>
							</div>
							<div class="masonry-news-list_meta-info clearfix">
								<div class="user-info">
									<a class="ava female small"><img alt="" src="http://img.happy-giraffe.ru/avatars/19372/small/21fd8c8f29c5a289df17938cb2f20e5b.jpg"></a>
									<div class="details">
										<a class="username" href="">Александр</a>
										<span class="date">Сегодня 13:25</span>
									</div>
								</div>
							</div>
						</div>
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
							<p>Роды — отправная точка для самых важных изменений и судьбоносных... <a href="" class="all">Читать</a></p>
						</div>
					</li>
					<li class="masonry-news-list_item">
						<div class="masonry-news-list_comment top">
							<div class="masonry-news-list_comment-text">
								<a href="">проблема в том, что на 2006-ой год игры еще толком не было...</a>
							</div>
							<div class="masonry-news-list_meta-info clearfix">
								<div class="user-info">
									<a class="ava female small"><img alt="" src="http://img.happy-giraffe.ru/avatars/19372/small/21fd8c8f29c5a289df17938cb2f20e5b.jpg"></a>
									<div class="details">
										<a class="username" href="">Александр</a>
										<span class="date">Сегодня 13:25</span>
									</div>
								</div>
							</div>
						</div>
						<h3 class="masonry-news-list_title">
							<a href="">Волшебная азбука</a>
							<a href="" class="icon-photo"></a>
						</h3>
						<div class="clearfix">
							<a href="" class="club-category">Раннее развитие и обучение</a>
						</div>
						<div class="masonry-news-list_meta-info clearfix">
							
							<div class="meta">
								<div class="views"><span class="icon" href="#"></span> <span>265</span></div>
								<div class="comments">
									<a class="icon" href="#"></a>
									<a href="">152</a>
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
							<ul class="masonry-news-list_img-list clearfix">
								<li><a href=""><img src="/images/example/w64-h61-1.jpg" alt="" /></a></li>
								<li><a href=""><img src="/images/example/w64-h61-2.jpg" alt="" /></a></li>
								<li><a href=""><img src="/images/example/w64-h61-2.jpg" alt="" /></a></li>
								<li><a href=""><img src="/images/example/w64-h61-1.jpg" alt="" /></a></li>
								<li><a href=""><img src="/images/example/w64-h61-2.jpg" alt="" /></a></li>
								<li><a href=""><img src="/images/example/w64-h61-1.jpg" alt="" /></a></li>
								<li><a href=""><img src="/images/example/w64-h61-2.jpg" alt="" /></a></li>
								<li><a href=""><img src="/images/example/w64-h61-1.jpg" alt="" /></a></li>
								<li><a href=""><img src="/images/example/w64-h61-2.jpg" alt="" /></a></li>
							</ul>
						</div>
					</li>
				</ul>
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
							<div class="clearfix margin-t10">
								<div class="float-l margin-r15 margin-l10 clearfix">
									<img alt="" src="/images/section/cook/cook-book.png">
								</div>
								<div class="margin-b5">
									<div class="margin-b5">Моя кулинарная <br>книга</div>
									<a href="" class="color-carrot">1 288 рецептов</a>
								</div>
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
							<div class="clearfix margin-t10">
								<div class="float-l margin-r15 margin-l10 clearfix">
									<img alt="" src="/images/section/cook/cook-book.png">
								</div>
								<div class="margin-b5">
									<div class="margin-b5">Моя кулинарная <br>книга</div>
									<a href="" class="color-carrot">1 288 рецептов</a>
								</div>
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
							<div class="clearfix margin-t10">
								<div class="float-l margin-r15 margin-l10 clearfix">
									<img alt="" src="/images/section/cook/cook-book.png">
								</div>
								<div class="margin-b5">
									<div class="margin-b5">Моя кулинарная <br>книга</div>
									<a href="" class="color-carrot">1 288 рецептов</a>
								</div>
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
							<div class="clearfix margin-t10">
								<div class="float-l margin-r15 margin-l10 clearfix">
									<img alt="" src="/images/section/cook/cook-book.png">
								</div>
								<div class="margin-b5">
									<div class="margin-b5">Моя кулинарная <br>книга</div>
									<a href="" class="color-carrot">1 288 рецептов</a>
								</div>
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
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15292/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/20909/small/e13fab92d1a406a9ffca8881a6afa24b.jpg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15292/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15292/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15292/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/20909/small/e13fab92d1a406a9ffca8881a6afa24b.jpg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15292/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15292/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/20909/small/e13fab92d1a406a9ffca8881a6afa24b.jpg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15292/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15292/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/15496/small/avatar.jpeg"></a></li>
						<li class="ava-small-list_li"><a href="" class="ava small"><img alt="" src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG"></a></li>
						<li class="ava-small-list_li"><span class="ava-small-list_count">еще 4 577</span></li>
					</ul>
				</div>
			</div>
			<div class="section_overlay">
				<div class="section-join">
					<div class="section-join_desc">
						<div class="section-join_t">А вот наши кулинары</div>
						<div class="section-join_tx">Мы здесь готовим вместе!</div>
					</div>
					<div class="section-join_btn btn-green btn-h55">Присоединяйтесь!</div>
				</div>
			</div>
		</div>
		<div class="section section__gray">
			<div class="section_hold">
				<div class="section_t-hold">
					<a href="" class="float-r"><i class="icon-friends-small"></i>Найти еще</a>
					<h2>Наши кулинары</h2>
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
							<div class="clearfix margin-t10">
								<div class="float-l margin-r15 margin-l10 clearfix">
									<img alt="" src="/images/section/cook/cook-book.png">
								</div>
								<div class="margin-b5">
									<div class="margin-b5">Моя кулинарная <br>книга</div>
									<a href="" class="color-carrot">1 288 рецептов</a>
								</div>
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
							<div class="clearfix margin-t10">
								<div class="float-l margin-r15 margin-l10 clearfix">
									<img alt="" src="/images/section/cook/cook-book.png">
								</div>
								<div class=margin-b5"">
									<div class="margin-b5">Моя кулинарная <br>книга</div>
									<a href="" class="color-carrot">1 288 рецептов</a>
								</div>
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
							<div class="clearfix margin-t10">
								<div class="float-l margin-r15 margin-l10 clearfix">
									<img alt="" src="/images/section/cook/cook-book.png">
								</div>
								<div class="margin-b5">
									<div class="margin-b5">Моя кулинарная <br>книга</div>
									<a href="" class="color-carrot">1 288 рецептов</a>
								</div>
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
							<div class="clearfix margin-t10">
								<div class="float-l margin-r15 margin-l10 clearfix">
									<img alt="" src="/images/section/cook/cook-book.png">
								</div>
								<div class="margin-b5">
									<div class="margin-b5">Моя кулинарная <br>книга</div>
									<a href="" class="color-carrot">1 288 рецептов</a>
								</div>
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
							<div class="clearfix margin-t10">
								<div class="float-l margin-r15 margin-l10 clearfix">
									<img alt="" src="/images/section/cook/cook-book.png">
								</div>
								<div class="margin-b5">
									<div class="margin-b5">Моя кулинарная <br>книга</div>
									<a href="" class="color-carrot">1 288 рецептов</a>
								</div>
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
							<div class="clearfix margin-t10">
								<div class="float-l margin-r15 margin-l10 clearfix">
									<img alt="" src="/images/section/cook/cook-book.png">
								</div>
								<div class="margin-b5">
									<div class="margin-b5">Моя кулинарная <br>книга</div>
									<a href="" class="color-carrot">1 288 рецептов</a>
								</div>
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
							<div class="clearfix margin-t10">
								<div class="float-l margin-r15 margin-l10 clearfix">
									<img alt="" src="/images/section/cook/cook-book.png">
								</div>
								<div class="margin-b5">
									<div class="margin-b5">Моя кулинарная <br>книга</div>
									<a href="" class="color-carrot">1 288 рецептов</a>
								</div>
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
							<div class="clearfix margin-t10">
								<div class="float-l margin-r15 margin-l10 clearfix">
									<img alt="" src="/images/section/cook/cook-book.png">
								</div>
								<div class="margin-b5">
									<div class="margin-b5">Моя кулинарная <br>книга</div>
									<a href="" class="color-carrot">1 288 рецептов</a>
								</div>
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
