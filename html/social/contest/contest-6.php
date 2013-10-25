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
			
			<div id="contest" class="contest contest-6">
				<div class="section-banner">
					<div class="button-holder">
						<a href=""class="contest-button">Участвовать!</a>
						<div class="contest-error-hint" style="display:block;">
							<h4>Oops!</h4><p>Что бы проголосовать, вам нужно пройти <a href='#'>Первые 6 шагов</a> в свой анкете </p>
						</div>
					</div>
					<img src="/images/contest/banner-w1000-6.jpg" />
				</div>
				
				<div class="contest-nav clearfix">
					<ul>
						<li class="active"><a href="">О конкурсе</a></li>
						<li><a href="">Правила</a></li>
						<li><a href="">Призы</a></li>
						<li><a href="">Участники</a></li>
					</ul>
				</div>
				<div class="contest-about clearfix">
					<div class="contest-participant">
						<img src="/images/contest/widget-6.jpg" alt="" calss="contest-title" />
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
					
					<p>Кормление малыша - это увлекательная игра, полная забавных моментов. И невозможно удержаться, чтобы их не сфотографировать!</p>
					<p>А у вас есть забавные фото вашего ребенка, на которых он ест? Скорее присылайте их на наш новый фотоконкурс “Кроха кушает”, и выигрывайте полезные призы!</p>
					
				</div>
				
				<div class="content-title">Вас ждут замечательные призы!</div>
				
				<div class="contest-prizes-list contest-prizes-list-6 clearfix">
					
					<ul>
						<li>
							<div class="img">
								<a href=""><img src="/images/prize_16.jpg" /></a>
							</div>
							<div class="place place-1-1"></div>
							<div class="title">
								Детские электронные весы<br/><b>LAICA PS3003 (Италия)</b>
							</div>
							<a href="" class="all">Подробнее</a>
						</li>
						<li>
							<div class="img">
								<a href=""><img src="/images/prize_17.jpg" /></a>
							</div>
							<div class="place place-2"></div>
							<div class="title">
								Мини-блендер<br/><b>Philips AVENT SCF 860/22</b>
							</div>
							<a href="" class="all">Подробнее</a>
						</li>
						<li>
							<div class="img">
								<a href=""><img src="/images/prize_18.jpg" /></a>
							</div>
							<div class="place place-3"></div>
							<div class="title">
								Мини-комбайн<br/><b>Maman ЕС01М </b>
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
	
	<div id="login" class="popup">
		
		<a href="javascript:void(0);" onclick="$.fancybox.close();" class="popup-close"><span class="tip">Закрыть</span></a>
		
		<div class="popup-title">Вход на сайт</div>
		
		<form>
			<div class="form">
				
				<div class="a-right login-btn">
					
					<div class="remember">
						<label><input type="checkbox" /><br/>Запомнить меня</label>
					</div>
					
					<button class="btn btn-green-arrow-big"><span><span>Войти</span></span></button>
					
				</div>
				
				<div class="row">
					<div class="row-title">Ваш e-mail:</div>
					<div class="row-elements"><input type="text" /></div>
				</div>
				
				<div class="row">
					<div class="row-title">Ваш пароль:</div>
					<div class="row-elements"><input type="password" /></div>
					<div class="row-bottom"><a href="">Забыли пароль?</a></div>
				</div>
				
				<div class="row row-social">
					Быстрый вход:
					&nbsp;
					<a href=""><img src="/images/icon_social_odnoklassniki.png" /></a>
					<a href=""><img src="/images/icon_social_vkontakte.png" /></a>
					<a href=""><img src="/images/icon_social_mailru.png" /></a>
				</div>
				
				<div class="reg-link">
					
					<div class="a-right">
						<a class="btn btn-orange" href=""><span><span>Зарегистрироваться</span></span></a>
					</div>
					
					<div class="row"><span>Еще нет учетной записи?</span></div>
					
				</div>
				
			</div>
		</form>
		
	</div>
	
	<div id="takeapartPhotoContest" class="popup">
		
		<a href="javascript:void(0);" onclick="$.fancybox.close();" class="popup-close"><span class="tip">Закрыть</span></a>
		
		<div class="popup-title">Я хочу участвовать в фотоконкурсе</div>
		
		<form>
			<div class="form">
				
				<div class="a-right upload-file">
					
					<div class="photo">
						<img src="/images/example/ex3.jpg" />
						<a href="" class="remove">Удалить</a>
					</div>
					
					<div class="file-fake">
						<button class="btn btn-orange"><span><span>Загрузить фото</span></span></button>
						<input type="file" />
					</div>
					
				</div>
				
				<div class="row">
					<div class="row-title">Название фото</div>
					<div class="row-elements"><input type="text" value="А Антошке я сплету другой..." /></div>
				</div>
				
				<div class="clear"></div>
				
				<div class="form-bottom">
					<label><input type="checkbox" /> Я согласен с</label> <a href="">Правилами конкурса</a>
					<button class="btn btn-green-arrow-big"><span><span>Участвовать</span></span></button>
				</div>
				
			</div>
		</form>
		
	</div>
	
</div>
</body>
</html>
