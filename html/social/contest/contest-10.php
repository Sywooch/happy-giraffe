<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="top-nav-fixed ie7"> <![endif]-->
<!--[if IE 8]>         <html class="top-nav-fixed ie8"> <![endif]-->
<!--[if IE 9]>         <html class="top-nav-fixed ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="top-nav-fixed"> <!--<![endif]-->
<head>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/head.php'; ?>

</head>
<body class="body-club">

	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/top-line-menu.php'; ?>
	
<div class="layout-container">
	<div class="layout-wrapper">
		<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/header-new.php'; ?>
			
	<script>
		$(function(){
			
			var $container = $('.gallery-photos-new');

			$container.imagesLoaded( function(){
				$container.masonry({
					itemSelector : 'li',
					columnWidth: 240,
					saveOptions: true,
					singleMode: false,
					resizeable: true
				});
			});
			
		})
	
	</script>

		<div id="content">
			
			<div id="contest" class="contest contest-10">
				<div class="section-banner">
					<!-- .button-holder - в этом конкурсе не используется -->
					<div class="button-holder">
						<a href=""class="contest-button">Участвовать!</a>
						<div class="contest-error-hint" style="display:block;">
							<h4>Oops!</h4><p>Что бы проголосовать, вам нужно пройти <a href='#'>Первые 6 шагов</a> в свой анкете </p>
						</div>
					</div>
					<img src="/images/contest/banner-w1000-10.jpg" />
				</div>
				
				<div class="contest-nav clearfix">
					<ul>
						<li class="active"><a href="">О конкурсе</a></li>
						<li><a href="">Правила</a></li>
						<li><a href="">Призы</a></li>
						<li><a href="">Участники</a></li>
					</ul>
				</div>
				
				<div class="contest-sponsor">
					<a href="">
						<img src="/images/contest/contest-sponsor-10.jpg" alt="" class="contest-sponsor_img">
					</a>
					
				</div>
				
				<div class="contest-about clearfix">
					<div class="contest-participant">
						<img src="/images/contest/widget-10.jpg" alt="" calss="contest-title" />
						<div class="img">
							<a href="">
								<img src="/images/example/gallery_album_img_01.jpg">
								<span class="btn">Посмотреть</span>
							</a>
						<div class="item-title">Разнообразие десертов сицилийского стиля</div>
						</div>
						<div class="clearfix">
							<div class="position">
								<strong>18</strong> место
							</div>
							<div class="ball">
								<div class="ball-count">186</div>
								<div class="ball-text">баллов</div>
							</div>
						</div>
					</div>
					
					<div class="sticker">
						<big>Для участия в конкурсе Вам необходимо:</big>
						<p>Для того, чтобы принять участие в конкурсе, вы должны заполнить <a href="#">свой профиль</a> и информацию о членах своей семьи!</p>
						<center>
							<a href="#takeapartPhotoContest" class="btn-green btn-green-medium fancy">Участвовать<i class="arr-r"></i></a>
						</center>
					</div>
					
					<div class="content-title">О конкурсе</div>
					
					<p>У каждого ребенка есть любимая игрушка, которая становится его первым другом! Плюшевый мишка или забавный зайчонок становится полноправным членом семьи - с ним малыш гуляет, кушает, доверяет свои детские тайны, и засыпает, крепко прижав друга к себе.  </p>
					<p>Присылайте фото своего малыша с первым другом и получайте замечательные призы, которые очень понравятся вашему ребенку!</p>
					
				</div>
				
				<div class="content-title">Вас ждут замечательные призы!</div>
				
				<div class="contest-prizes-list contest-prizes-list-10 clearfix">
					
					<ul>
						<li>
							<div class="img">
								<a href=""><img src="/images/prize_29.jpg" /></a>
							</div>
							<div class="place place-1-1"></div>
							<div class="title">
								Первая игрушка вашего ребенка <br/><b>Комфортер «Cuski»</b>
								<br> <i class="contest-prizes-list-10_color-beige">бежевый цвет</i>
							</div>
							<a href="" class="all">Подробнее</a>
						</li>
						<li>
							<div class="img">
								<a href=""><img src="/images/prize_30.jpg" /></a>
							</div>
							<div class="place place-2"></div>
							<div class="title">
								Первая игрушка вашего ребенка <br/><b>Комфортер «Cuski»</b>
								<br> <i class="contest-prizes-list-10_color-pink">светло-розовый цвет</i>
							</div>
							<a href="" class="all">Подробнее</a>
						</li>
						<li>
							<div class="img">
								<a href=""><img src="/images/prize_31.jpg" /></a>
							</div>
							<div class="place place-3"></div>
							<div class="title">
								Первая игрушка вашего ребенка <br/><b>Комфортер «Cuski»</b>
								<br> <i class="contest-prizes-list-10_color-blue">светло-голубой цвет</i>
							</div>
							<a href="" class="all">Подробнее</a>
						</li>
					</ul>
					
				</div>
				
				<div class="content-title">
					Последние добавленные фото
					<a href="" class="btn-blue-light btn-blue-light-small">Показать все</a>
				</div>
            </div>
				
                    <div class="gallery-photos-new cols-4 clearfix">
								
						<ul>
							<li>
								<div class="contest-ball clearfix">
									<div class="user-info clearfix">
										<a class="ava female small"></a>
										<div class="details">
											<span class="icon-status status-online"></span>
											<a href="" class="username">Александр Богоявленский</a>
										</div>
										<div class="ball">
											<div class="ball-count">186</div>
											<div class="ball-text">баллов</div>
										</div>
									</div>
								</div>
								<div class="img">
									<a href="">
										<img src="/images/example/gallery_album_img_01.jpg" />
										<span class="btn">Посмотреть</span>
									</a>
								</div>
								
								<div class="item-title">Разнообразие десертов сицилийского стиля</div>
							</li>
							<li>
								<div class="contest-ball clearfix">
									<div class="user-info clearfix">
										<a class="ava female small"></a>
										<div class="details">
											<span class="icon-status status-online"></span>
											<a href="" class="username">Александр Богоявленский</a>
										</div>
										<div class="ball">
											<div class="ball-count">186</div>
											<div class="ball-text">баллов</div>
										</div>
									</div>
								</div>
								<div class="img">
									<a href="">
										<img src="/images/example/gallery_album_img_02.jpg" />
										<span class="btn">Посмотреть</span>
									</a>
									
								</div>
								<div class="item-title">Разнообразие десертов сицилийского стиля</div>
							</li>
							<li>
								<div class="contest-ball clearfix">
									<div class="user-info clearfix">
										<a class="ava female small"></a>
										<div class="details">
											<span class="icon-status status-online"></span>
											<a href="" class="username">Александр Богоявленский</a>
										</div>
										<div class="ball">
											<div class="ball-count">186</div>
											<div class="ball-text">баллов</div>
										</div>
									</div>
								</div>
								<div class="img">
									<a href="">
										<img src="/images/example/gallery_album_img_03.jpg" />
										<span class="btn">Посмотреть</span>
									</a>
								</div>
								<div class="item-title">Разнообразие десертов сицилийского стиля</div>
							</li>
							<li>
								<div class="contest-ball clearfix">
									<div class="user-info clearfix">
										<a class="ava female small"></a>
										<div class="details">
											<span class="icon-status status-online"></span>
											<a href="" class="username">Александр Богоявленский</a>
										</div>
										<div class="ball">
											<div class="ball-count">186</div>
											<div class="ball-text">баллов</div>
										</div>
									</div>
								</div>
								<div class="img">
									<a href="">
										<img src="/images/example/gallery_album_img_04.jpg" />
										<span class="btn">Посмотреть</span>
									</a>
								</div>
								<div class="item-title">Разнообразие десертов сицилийского стиля</div>
							</li>
							<li>
								<div class="contest-ball clearfix">
									<div class="user-info clearfix">
										<a class="ava female small"></a>
										<div class="details">
											<span class="icon-status status-online"></span>
											<a href="" class="username">Александр Богоявленский</a>
										</div>
										<div class="ball">
											<div class="ball-count">186</div>
											<div class="ball-text">баллов</div>
										</div>
									</div>
								</div>
								<div class="img">
									<a href="">
										<img src="/images/example/gallery_album_img_05.jpg" />
										<span class="btn">Посмотреть</span>
									</a>
								</div>
								<div class="item-title">Разнообразие десертов сицилийского стиля</div>
							</li>
							<li>
								<div class="contest-ball clearfix">
									<div class="user-info clearfix">
										<a class="ava female small"></a>
										<div class="details">
											<span class="icon-status status-online"></span>
											<a href="" class="username">Александр Богоявленский</a>
										</div>
										<div class="ball">
											<div class="ball-count">186</div>
											<div class="ball-text">баллов</div>
										</div>
									</div>
								</div>
								<div class="img">
									<a href="">
										<img src="/images/example/gallery_album_img_06.jpg" />
										<span class="btn">Посмотреть</span>
									</a>
								</div>
								<div class="item-title">Разнообразие десертов сицилийского стиля</div>
							</li>
							<li>
								<div class="contest-ball clearfix">
									<div class="user-info clearfix">
										<a class="ava female small"></a>
										<div class="details">
											<span class="icon-status status-online"></span>
											<a href="" class="username">Александр Богоявленский</a>
										</div>
										<div class="ball">
											<div class="ball-count">186</div>
											<div class="ball-text">баллов</div>
										</div>
									</div>
								</div>
								<div class="img">
									<a href="">
										<img src="/images/example/gallery_album_img_07.jpg" />
										<span class="btn">Посмотреть</span>
									</a>
								</div>
								<div class="item-title">Разнообразие десертов сицилийского стиля</div>
							</li>
							<li>
								<div class="contest-ball clearfix">
									<div class="user-info clearfix">
										<a class="ava female small"></a>
										<div class="details">
											<span class="icon-status status-online"></span>
											<a href="" class="username">Александр Богоявленский</a>
										</div>
										<div class="ball">
											<div class="ball-count">186</div>
											<div class="ball-text">баллов</div>
										</div>
									</div>
								</div>
								<div class="img">
									<a href="">
										<img src="/images/example/gallery_album_img_08.jpg" />
										<span class="btn">Посмотреть</span>
									</a>
								</div>
								<div class="item-title">Разнообразие десертов сицилийского стиля</div>
							</li>
							<li>
								<div class="contest-ball clearfix">
									<div class="user-info clearfix">
										<a class="ava female small"></a>
										<div class="details">
											<span class="icon-status status-online"></span>
											<a href="" class="username">Александр Богоявленский</a>
										</div>
										<div class="ball">
											<div class="ball-count">186</div>
											<div class="ball-text">баллов</div>
										</div>
									</div>
								</div>
								<div class="img">
									<a href="">
										<img src="/images/example/gallery_album_img_09.jpg" />
										<span class="btn">Посмотреть</span>
									</a>
								</div>
								<div class="item-title">Разнообразие десертов сицилийского стиля</div>
							</li>
							<li>
								<div class="contest-ball clearfix">
									<div class="user-info clearfix">
										<a class="ava female small"></a>
										<div class="details">
											<span class="icon-status status-online"></span>
											<a href="" class="username">Александр Богоявленский</a>
										</div>
										<div class="ball">
											<div class="ball-count">186</div>
											<div class="ball-text">баллов</div>
										</div>
									</div>
								</div>
								<div class="img">
									<a href="">
										<img src="/images/example/gallery_album_img_10.jpg" />
										<span class="btn">Посмотреть</span>
									</a>
								</div>
								<div class="item-title">Разнообразие десертов сицилийского стиля</div>
							</li>
							<li>
								<div class="contest-ball clearfix">
									<div class="user-info clearfix">
										<a class="ava female small"></a>
										<div class="details">
											<span class="icon-status status-online"></span>
											<a href="" class="username">Александр Богоявленский</a>
										</div>
										<div class="ball">
											<div class="ball-count">186</div>
											<div class="ball-text">баллов</div>
										</div>
									</div>
								</div>
								<div class="img">
									<a href="">
										<img src="/images/example/gallery_album_img_11.jpg" />
										<span class="btn">Посмотреть</span>
									</a>
								</div>
								<div class="item-title">Разнообразие десертов сицилийского стиля</div>
							</li>
							<li>
								<div class="contest-ball clearfix">
									<div class="user-info clearfix">
										<a class="ava female small"></a>
										<div class="details">
											<span class="icon-status status-online"></span>
											<a href="" class="username">Александр Богоявленский</a>
										</div>
										<div class="ball">
											<div class="ball-count">186</div>
											<div class="ball-text">баллов</div>
										</div>
									</div>
								</div>
								<div class="img">
									<a href="">
										<img src="/images/example/gallery_album_img_12.jpg" />
										<span class="btn">Посмотреть</span>
									</a>
								</div>
								<div class="item-title">Разнообразие десертов сицилийского стиля</div>
							</li>
							
						</ul>
					
					</div>
				
				
			</div>
		<div class="footer-push"></div>
	</div>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/footer.php'; ?>
</div>
<div style="display:none">

</div>
</body>
</html>
