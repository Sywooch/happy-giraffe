﻿<!DOCTYPE html>
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
			
				<div class="content-cols clearfix">
					<div class="col-1">
						Left side 240px
					</div>
					<div class="col-23">
						content column 700px
					</div>
				</div>
		</div>
		<div id="broadcast" class="broadcast-all">
						<div class="broadcast-widget">
							<div class="broadcast-title-box clearfix">
								<ul class="broadcast-widget-menu">
									<li class="is-active">
										<a href="">
											<span class="icon-boradcast-small" ></span>
											<span class="text">В прямом эфире</span>
										</a>
									</li>
									<li>
										<a href=""><span class="text">В клубах</span></a>
									</li>
									<li>
										<a href=""><span class="text">В блогах</span></a>
									</li>
									<li>
										<a href=""><span class="icon-friends" ></span><span class="text">У друзей</span></a>
									</li>
								</ul>
								<h3><i class="icon-boradcast"></i> Что нового</h3>
							</div>
								<script>
									$(function(){
										$('#masonry-news-list-jcarousel').jcarousel({
											list: '#masonry-news-list-jcarousel-ul',
											items: '.masonry-news-list_item',
											tail: 2
										});

										// Setup controls for the navigation carousel
								        $('#masonry-news-list-jcarousel .prev')
								            .on('inactive.jcarouselcontrol', function() {
								                $(this).addClass('inactive');
								            })
								            .on('active.jcarouselcontrol', function() {
								                $(this).removeClass('inactive');
								            })
								            .jcarouselControl({
								                target: '-=3'
								            });

								        $('#masonry-news-list-jcarousel .next')
								            .on('inactive.jcarouselcontrol', function() {
								                $(this).addClass('inactive');
								            })
								            .on('active.jcarouselcontrol', function() {
								                $(this).removeClass('inactive');
								            })
								            .jcarouselControl({
								                target: '+=3'
								            });
									})
								</script>
								<div id="masonry-news-list-jcarousel" class="masonry-news-list jcarousel-holder clearfix">
								
									<a class="prev" href="#" >предыдущая</a>
									<a class="next jcarousel-next" href="#">следующая</a>
									<!--<a href="javascript:void(0);" onclick="$('#masonry-news-list-jcarousel').jcarousel('scroll', '-=1')" class="prev">предыдущая</a>
									 <a href="javascript:void(0);" onclick="$('#masonry-news-list-jcarousel').jcarousel('scroll', '+=1')" class="next">следующая</a> -->
									 <div class="jcarousel" >
										<ul id="masonry-news-list-jcarousel-ul">
									
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
											<a href=""><img src="/images/example/gallery_album_img_10.jpg" alt="" /></a>
										</div>
									</li>
									<li class="masonry-news-list_item">
										
										<div class="masonry-news-list_comment top">
											<div class="masonry-news-list_meta-info clearfix">
												<div class="user-info">
													<a class="ava female small"><img alt="" src="http://img.happy-giraffe.ru/avatars/19372/small/21fd8c8f29c5a289df17938cb2f20e5b.jpg"></a>
													<div class="details">
														<a class="username" href="">Александр</a>
														<span class="date">Сегодня 13:25</span>
													</div>
												</div>
											</div>
											
											<div class="masonry-news-list_comment-text">
												<a href="">проблема в том, что на 2006-ой год игры еще толком не было...</a>
											</div>
										</div>
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
											<a href=""><img src="/images/example/gallery_album_img_10.jpg" alt="" /></a>
											<p>Роды — отправная точка для самых важных изменений и судьбоносных... <a href="" class="all">Читать</a></p>
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
										<div class="masonry-news-list_comment top">
											<div class="masonry-news-list_meta-info clearfix">
												<div class="user-info">
													<a class="ava female small"><img alt="" src="http://img.happy-giraffe.ru/avatars/19372/small/21fd8c8f29c5a289df17938cb2f20e5b.jpg"></a>
													<div class="details">
														<a class="username" href="">Александр</a>
														<span class="date">Сегодня 13:25</span>
													</div>
												</div>
											</div>
											
											<div class="masonry-news-list_comment-text">
												<a href="">проблема в том, что на 2006-ой год игры еще толком не было...</a>
											</div>
										</div>
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
											<a href=""><img src="/images/example/gallery_album_img_10.jpg" alt="" /></a>
											<p>Роды — отправная точка для самых важных изменений и судьбоносных... <a href="" class="all">Читать</a></p>
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
											<a href=""><img src="/images/example/gallery_album_img_10.jpg" alt="" /></a>
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
											<img src="/images/broadcast/title-contest-4.jpg" alt="" class="title-img"/>
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
									<li class="masonry-news-list_item">
										<h3 class="masonry-news-list_title">
											<a href="">Новые участники фотоконкурса</a>
											<a href="" class="icon-photo"></a>
										</h3>
										<div class="clearfix">
											<span class="date">Сегодня 13:25</span>
										</div>
										<div class="clearfix">
											<img src="/images/broadcast/title-contest-4.jpg" alt="" class="title-img"/>
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