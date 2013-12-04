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

		<div class="layout-content margin-l0 clearfix">
		<div class="content-cols ">
			<div class="col-white">	
				<div id="contest" class="contest contest-13">
					<div class="section-banner">
						<!-- .button-holder - в этом конкурсе не используется -->
						<div class="button-holder">
							<a href=""class="contest-button">Участвовать!</a>
							<!-- Сейчас нет шагов после регистрации -->
							<!-- <div class="contest-error-hint" style="display:block;">
								<h4>Oops!</h4><p>Что бы проголосовать, вам нужно пройти <a href='#'>Первые 6 шагов</a> в свой анкете </p>
							</div> -->
						</div>
						<img src="/images/contest/banner-w1000-13.jpg" />
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
						<a href="http://www.neopod.ru" title="neopod.ru"><img src="/images/contest/contest-sponsor-13-1.jpg" alt="" class="contest-sponsor_img"></a>
						
					</div>
					
					<div class="contest-about clearfix">
						 <div class="contest-participant">
							<div class="contest-participant_t">Моя работа в конкурсе</div>
							<div class="img">
								<div class="clearfix">
									<div class="position">
										<strong>18</strong> место
									</div>
									<div class="ball">
										<div class="ball-count">186</div>
										<div class="ball-text">баллов</div>
									</div>
								</div>
								<a href="">
									<img src="/images/example/gallery_album_img_01.jpg">
									<span class="btn">Посмотреть</span>
								</a>
							<div class="item-title">Разнообразие десертов сицилийского стиля</div>
							</div>
						</div>
						<!-- 
						<div class="sticker">
							<big>Для участия в конкурсе Вам необходимо:</big>
							<p>Для того, чтобы принять участие в конкурсе, вы должны заполнить <a href="#">свой профиль</a> и информацию о членах своей семьи!</p>
							<center>
								<a href="#takeapartPhotoContest" class="btn-green btn-green-medium fancy">Участвовать<i class="arr-r"></i></a>
							</center>
						</div> -->
						 
						<div class="content-title">О конкурсе</div>
						
						<p>У каждого ребенка есть любимая игрушка, которая становится его первым другом! Плюшевый мишка или забавный зайчонок становится полноправным членом семьи - с ним малыш гуляет, кушает, доверяет свои детские тайны, и засыпает, крепко прижав друга к себе.</p>
						<p>Присылайте фото своего малыша с любимой игрушкой и получайте замечательные призы, которые очень понравятся вашему ребенку! </p>
						
					</div>
					
					<div class="content-title">Вас ждут замечательные призы!</div>
					
					<div class="contest-prizes-list contest-prizes-list-13 clearfix">
						
						<ul>
							<li>
								<div class="img">
									<a href=""><img src="/images/prize_47.jpg" /></a>
								</div>
								<div class="place place-1-1"></div>
								<div class="title">
									Детский электромобиль <b>NeoTrike Beetle </b> <br> зеленый с пультом радиоуправления
								</div>
								<a href="" class="all">Подробнее</a>
							</li>
							<li>
								<div class="img">
									<a href=""><img src="/images/prize_48.jpg" /></a>
								</div>
								<div class="place place-2"></div>
								<div class="title">
									Обучающий компьютер Винни <br><b>VTech</b>
								</div>
								<a href="" class="all">Подробнее</a>
							</li>
							<li>
								<div class="img">
									<a href=""><img src="/images/prize_49.jpg" /></a>
								</div>
								<div class="place place-3"></div>
								<div class="title">
									Развивающая игрушка <br> Обучающий глобус <b>VTech </b>
								</div>
								<a href="" class="all">Подробнее</a>
							</li>
						</ul>
						
					</div>
					
					<div class="content-title">
						<a href="" class="i-more float-r">Все участники (268)</a>
						Последние добавленные фото

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
										<a href="" class="username">Александр</a>
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
										<a href="" class="username">Богоявленский</a>
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
			</div>
		</div>
		<div class="footer-push"></div>
	</div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/footer.php'; ?>
</body>
</html>
