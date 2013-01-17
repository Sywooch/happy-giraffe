<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="top-nav-fixed ie7"> <![endif]-->
<!--[if IE 8]>         <html class="top-nav-fixed ie8"> <![endif]-->
<!--[if IE 9]>         <html class="top-nav-fixed ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="top-nav-fixed"> <!--<![endif]-->
<head>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/head.php'; ?>

</head>
<body class="body-gray">

	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/top-line-menu.php'; ?>
	
<div class="layout-container">
	<div class="layout-wrapper">
		<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/header-new.php'; ?>
		
		<div id="content" class="clearfix">
			
			<div id="broadcast" class="broadcast-all">
				
				<div class="broadcast-title-box">
					<h1><i class="icon-boradcast"></i> Что нового</h1>
					<ul class="broadcast-menu">
						<li class="active">
							<a href="">Прямой эфир</a>
						</li>
						<li>
							<a href="">В клубах</a>
							<ul class="broadcast-menu_drop">
								<li class="active"><a href="">В моих</a></li>
								<li><a href="">Во всех</a></li>
							</ul>
						</li>
						<li>
							<a href="">В блогах</a>
							<ul class="broadcast-menu_drop">
								<li><a href="">В моих</a></li>
								<li><a href="">Во всех</a></li>
							</ul>
						</li>
						<li>
							<a href="">У друзей</a>
							<ul class="broadcast-menu_drop">
								<li><a href="">В моих</a></li>
								<li><a href="">Во всех</a></li>
							</ul>
						</li>
					</ul>
				</div>
				
				<div class="content-cols clearfix">
				
						<div class="masonry-news-list">
						<script>
  $(function(){

        $(".masonry-news-list").masonry({
          itemSelector : '.masonry-news-list_item',
          columnWidth: 240,
          isAnimated: false,
          animationOptions: { queue: false, duration: 500 }
        });

  })
						</script>
							<ul>
								<li class="masonry-news-list_item update-message">
									<div class="icon-broadcast"></div>
									<div class="desc">Если, пока вы читаете, <br />появятся новые события, <br />мы вам сообщим здесь.
									</div>
								</li>
								<li class="masonry-news-list_item update-message new">
									<div class="count">14</div>
									<div class="desc">
										<span class="red">Внимание! </span> <br />
										Появились новые события
									</div>
									<a href="" class="btn-update">Обновить</a>
								</li>
								<li class="masonry-news-list_item">
									<h3 class="masonry-news-list_title">
										<a href="">Волшебная азбука</a>
										<a href="" class="icon-video"></a>
									</h3>
									<div class="clearfix">
										<a href="" class="club-category beauty">Раннее развитие и обучение</a>
									</div>
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
										<a href="">
											<img alt="" src="/images/example/gallery_album_img_10.jpg">
											<span class="btn-view">Посмотреть</span>
										</a>
										<p>Роды — отправная точка для самых важных изменений и судьбоносных... <a href="" class="all">Читать</a></p>
									</div>
									<div class="masonry-news-list_comment">
										<div class="masonry-news-list_comment-text">
											Проблема в том, что на 2006-ой год игры еще толком не было, Роды — отправная точка для самых важных изменений и судьбоносных. Осень. Я ее люблю, но когда начинается непонятная погода, хочется лезть на стенку. Сегодня на улице вот +8, вроде тепло, но вот туман.
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
								</li>
								<li class="masonry-news-list_item">
									<h3 class="masonry-news-list_title">
										<a href="">Волшебная азбука. Раннее развитие и обучение.</a>
									</h3>
									<div class="clearfix">
										<a href="" class="club-category manwoman">Раннее развитие и обучение.</a>
									</div>
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
									
									<div class="comments-all">
										<a href="">еще 124</a>
										<a href="" class="icon-comment"></a>
									</div>
								</li>
								<li class="masonry-news-list_item">
									<h3 class="masonry-news-list_title">
										<a href="">Волшебная азбука 123</a>
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
										<a href="">
											<img alt="" src="/images/example/gallery_album_img_10.jpg">
											<span class="btn-view">Посмотреть</span>
										</a>
									</div>
								</li>
								<li class="masonry-news-list_item">
									<h3 class="masonry-news-list_title">
										<a href="">Волшебная азбука</a>
										<a href="" class="icon-video"></a>
									</h3>
									<div class="clearfix">
										<a href="" class="club-category beauty">Раннее развитие и обучение</a>
									</div>
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
										<div class="title-img">
											<a href="">
												<img alt="" src="http://img.happy-giraffe.ru/thumbs/198x/57695/02d38dff5d7752c98c209ffda04067c2.JPG">
												<span class="btn-view">Посмотреть</span>
											</a>
											
										</div>
										<p>Роды — отправная точка для самых важных изменений и судьбоносных... <a href="" class="all">Читать</a></p>
									</div>
									<div class="masonry-news-list_comment">
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
									
									<div class="comments-all">
										<a href="">еще 124</a>
										<a href="" class="icon-comment"></a>
									</div>
								</li>
								<li class="masonry-news-list_item">
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
									
									<div class="masonry-news-list_comment">
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
									<div class="comments-all">
										<a href="">еще 124</a>
										<a href="" class="icon-comment"></a>
									</div>
								</li>
								<li class="masonry-news-list_item blog">
									<h3 class="masonry-news-list_title">
										<a href="">Волшебная азбука</a>
										<a href="" class="icon-photo"></a>
									</h3>
									<div class="clearfix">
										<a href="" class="sub-category"><span class="icon-blog"></span>Личный блог</a>
									</div>
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
										<div class="title-img">
											<a href="">
												<img alt="" src="http://img.happy-giraffe.ru/thumbs/198x/15836/e4aabee8a19e4745d30790f51d0b24b1.jpg">
												<span class="btn-view">Посмотреть</span>
											</a>
											
										</div>
										<p>Роды — отправная точка для самых важных изменений и судьбоносных... <a href="" class="all">Читать</a></p>
									</div>
									<div class="masonry-news-list_comment">
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
									
									<div class="comments-all">
										<a href="">еще 124</a>
										<a href="" class="icon-comment"></a>
									</div>
								</li>
								<li class="masonry-news-list_item">
									<h3 class="masonry-news-list_title textalign-c">
										<a href="">Новые пользователи</a>
									</h3>
									<div class="textalign-c clearfix">
										<span class="date">Сегодня 13:25</span>
									</div>
									<ul class="user-list">
										<li><a class="ava female" href=""><img alt="" src="http://img.happy-giraffe.ru/avatars/15814/ava/aeabe1581b7fcaa39a1c012adcf47b97.jpg"></a></li>
										<li><a class="ava female" href=""></a></li>
										<li><a class="ava female" href=""></a></li>
										<li><a class="ava female" href=""><img alt="" src="http://img.happy-giraffe.ru/avatars/15814/ava/aeabe1581b7fcaa39a1c012adcf47b97.jpg"></a></li>
										<li><a class="ava female" href=""><img alt="" src="http://img.happy-giraffe.ru/avatars/15814/ava/aeabe1581b7fcaa39a1c012adcf47b97.jpg"></a></li>
										<li><a class="ava female" href=""></a></li>
									</ul>
									<div class="textalign-c clearfix">
										<a href="" class="icon-friends"></a>
										<a href="">Смотреть всех новеньких</a>
									</div>
								</li>
								<li class="masonry-news-list_item">
									<h3 class="masonry-news-list_title">
										<a href="">Новые фото Оформление блюд</a>
										<a href="" class="icon-photo"></a>
									</h3>
									<div class="clearfix">
										<span class="date">Сегодня 13:25</span>
									</div>
									<div class="clearfix">
										<a href=""><img src="/images/broadcast/title-dishes.jpg" alt="" class="title-img"/></a>
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
									
									<div class="textalign-c clearfix">
										<a href="">Смотреть все</a>
									</div>
								</li>
								<li class="masonry-news-list_item">
									<h3 class="masonry-news-list_title">
										<a href="">Новые участники фотоконкурса</a>
										<a href="" class="icon-photo"></a>
									</h3>
									<div class="clearfix">
										<span class="date">Сегодня 13:25</span>
									</div>
									<div class="clearfix">
										<img src="/images/broadcast/title-contest-6.jpg" alt="" class="title-img"/>
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
									
									<div class="textalign-c clearfix">
										<a href="">Все участники (1802)</a>
									</div>
								</li>
								<li class="masonry-news-list_item cook">
									<h3 class="masonry-news-list_title">
										<a href="">Торт «Трио»</a>
									</h3>
									<div class="clearfix">
										<a href="" class="sub-category"><span class="icon-cook"></span>Кулинарный рецепт</a>
									</div>
									<div class="clearfix">
										<div class="title-img">
											<a href="">
												<img src="/images/example/gallery_album_img_10.jpg" alt="" />
												<span class="btn-view">Посмотреть</span>
											</a>
											
										</div>
									</div>
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
										<p>Желатин замочим в 3/4 стакана кипяченной прохладной воды.Смешиваем... <a href="" class="all">Читать</a></p>
									</div>
								</li>
								<div id="infscr-loading"><img alt="Loading..." src="/images/ico/ajax-loader.gif" /><div>Загрузка</div></div>
							</ul>
							
						</div>
				

				</div>

			</div>
		
		</div>
		<a href="#layout" id="btn-up-page"></a>
		<div class="footer-push"></div>
	</div>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/footer.php'; ?>
</div>

</body>
</html>