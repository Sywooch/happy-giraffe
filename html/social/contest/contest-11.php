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
				<div id="contest" class="contest contest-11">
					<div class="section-banner">
						<!-- .button-holder - в этом конкурсе не используется -->
						<div class="button-holder">
							<a href=""class="contest-button">Участвовать!</a>
							<div class="contest-error-hint" style="display:block;">
								<h4>Oops!</h4><p>Что бы проголосовать, вам нужно пройти <a href='#'>Первые 6 шагов</a> в свой анкете </p>
							</div>
						</div>
						<img src="/images/contest/banner-w1000-11.jpg" />
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
						<a href="http://www.neopod.ru"><img src="/images/contest/contest-sponsor-11-4.jpg" alt="" class="contest-sponsor_img"></a>
						<a href="http://www.neopod.ru/brands/neotrike/"><img src="/images/contest/contest-sponsor-11-5.jpg" alt="" class="contest-sponsor_img"></a>
						
					</div>
					
					<div class="contest-about clearfix">
						<div class="contest-participant">
							<img src="/images/contest/widget-11.jpg" alt="" calss="contest-title" />
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
						
						<p>Летняя прогулка с ребенком всегда превращается в целое приключение. Маленькие сорванцы ни секунды не могут усидеть на месте, и постоянно чем-то заняты: катанием на самокатах, машинках, роликах.</p>
						<p>Пришлите нам фотографию своего ребенка с его любимым транспортным средством и получите один из трех отличных призов! </p>
						
					</div>
					
					<div class="content-title">Вас ждут замечательные призы!</div>
					
					<div class="contest-prizes-list contest-prizes-list-11 clearfix">
						
						<ul>
							<li>
								<div class="img">
									<a href=""><img src="/images/prize_33.jpg" /></a>
								</div>
								<div class="place place-1-1"></div>
								<div class="title">
									Детский электромобиль <br/><b>NeoTrike Beetle</b>
								</div>
								<a href="" class="all">Подробнее</a>
							</li>
							<li>
								<div class="img">
									<a href=""><img src="/images/prize_34.jpg" /></a>
								</div>
								<div class="place place-2"></div>
								<div class="title">
									Детский электромобиль <br/><b>NeoTrike Commando</b>
								</div>
								<a href="" class="all">Подробнее</a>
							</li>
							<li>
								<div class="img">
									<a href=""><img src="/images/prize_35.jpg" /></a>
								</div>
								<div class="place place-3"></div>
								<div class="title">
									Детский электромобиль <br/><b>NeoTrike Mini Mercedes Benz </b>
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

				<div class="photo-grid photo-grid__contest clearfix">
			        <div class="photo-grid_row clearfix" >
			        	<!-- Ловить клик на photo-grid_i для показа увеличенного фото -->
		                <div class="photo-grid_i">
	                    	<img class="photo-grid_img" src="/images/example/photo-grid-13.jpg" alt="">
	                    	<div class="photo-grid_overlay">
	                    		<span class="photo-grid_zoom"></span>
	                    	</div>
	                    	<div class="photo-grid_ball">
	                    		<div class="photo-grid_ball-count">15</div>
	                    		баллов
	                    	</div>
	                    	<div class="photo-grid_author">
	                    		<a class="ava male" href="">
									<span class="icon-status status-online"></span>
									<img src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg" alt="">
								</a>
								<a href="" class="photo-grid_author-name">Ангелина Богоявленская</a>
								<div class="font-smallest color-gray"> Сегодня 13:25</div>
	                    	</div>
	                    	<div class="photo-grid_i-t">Ой коняка мой коняка ...</div>
		                </div>
		                <div class="photo-grid_i">
	                    	<img class="photo-grid_img" src="/images/example/photo-grid-14.jpg" alt="">
	                    	<div class="photo-grid_overlay">
	                    		<span class="photo-grid_zoom"></span>
	                    	</div>
		                </div>
		                <div class="photo-grid_i">
	                    	<img class="photo-grid_img" src="/images/example/photo-grid-15.jpg" alt="">
	                    	<div class="photo-grid_overlay">
	                    		<span class="photo-grid_zoom"></span>
	                    	</div>
		                </div>
			        </div>
			        <div class="photo-grid_row clearfix" >
			        	<!-- Ловить клик на photo-grid_i для показа увеличенного фото -->
		                <div class="photo-grid_i">
	                    	<img class="photo-grid_img" src="/images/example/photo-grid-4.jpg" alt="">
	                    	<div class="photo-grid_overlay">
	                    		<span class="photo-grid_zoom"></span>
	                    	</div>
		                </div>
		                <div class="photo-grid_i">
	                    	<img class="photo-grid_img" src="/images/example/photo-grid-5.jpg" alt="">
	                    	<div class="photo-grid_overlay">
	                    		<span class="photo-grid_zoom"></span>
	                    	</div>
		                </div>
		                <div class="photo-grid_i">
	                    	<img class="photo-grid_img" src="/images/example/photo-grid-6.jpg" alt="">
	                    	<div class="photo-grid_overlay">
	                    		<span class="photo-grid_zoom"></span>
	                    	</div>
		                </div>
			        </div>
			        <div class="photo-grid_row clearfix" >
			        	<!-- Ловить клик на photo-grid_i для показа увеличенного фото -->
		                <div class="photo-grid_i">
	                    	<img class="photo-grid_img" src="/images/example/photo-grid-3.jpg" alt="">
	                    	<div class="photo-grid_overlay">
	                    		<span class="photo-grid_zoom"></span>
	                    	</div>
		                </div>
		                <div class="photo-grid_i">
	                    	<img class="photo-grid_img" src="/images/example/photo-grid-1.jpg" alt="">
	                    	<div class="photo-grid_overlay">
	                    		<span class="photo-grid_zoom"></span>
	                    	</div>
		                </div>
		                <div class="photo-grid_i">
	                    	<img class="photo-grid_img" src="/images/example/photo-grid-2.jpg" alt="">
	                    	<div class="photo-grid_overlay">
	                    		<span class="photo-grid_zoom"></span>
	                    	</div>
		                </div>
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
			</div>
		</div>
		<div class="footer-push"></div>
	</div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/footer.php'; ?>
</body>
</html>
