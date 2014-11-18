<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="ie7"> <![endif]-->
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class=""> <!--<![endif]-->
<head>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/head.php'; ?>
	<link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,100&amp;subset=latin,cyrillic-ext,cyrillic">
	
	<script type="text/javascript">
	$(".chzn").chosen().ready(function(){
	    
	    $('.chzn-itx-simple').find('.chzn-drop').append("<div class='chzn-itx-simple_add clearfix'><button class='btn-green'>Ok</button><div class='chzn-itx-simple_add-hold'> <input type='text' name='' id='' class='chzn-itx-simple_add-itx' placeholder="Создать новую рубрику"> <a href='' class='chzn-itx-simple_add-del'></a> </div>  </div>");

	  });
	</script>

	<script>
	$(document).ready(function () {


	    $('body').delegate('a.fancy-top', 'click', function () {
	        var onComplete_function = function () {

	            var scTop = $(document).scrollTop();
	            var box = $('#fancybox-wrap');

	            boxTop = parseInt(Math.max(scTop + 40));
	            box
	                .stop()
	                .animate({
	                    'top' : boxTop
	                }, 200);
	            
	        };

	        $(this).clone().fancybox({
	            overlayColor:'#2d1a3f',
	            overlayOpacity:'0.6',
	            padding:0,
	            hideOnOverlayClick:false,
	            showCloseButton:false,
	            centerOnScroll:false,
	            onComplete:onComplete_function
	        }).trigger('click');
	        return false;
	    });
	})
	</script>

</head>
<body class="body-gray">

	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/top-line-menu.php'; ?>
	
<div class="layout-container">
	<div class="layout-wrapper">
		<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/header-new.php'; ?>
		
		<div class="layout-content clearfix">
		<div class="content-cols clearfix">
			<div class="col-1">
				<div class="sidebar-search clearfix">
					<input type="text" placeholder="Поиск по сайту" class="sidebar-search_itx" id="" name="">
					<!-- 
					В начале ввода текста, скрыть sidebar-search_btn добавить класс active"
					 -->
					<button class="sidebar-search_btn"></button>
				</div>
			</div>
			<div class="col-23-middle">
				<div class="user-add-record clearfix">
					<div class="user-add-record_ava-hold">
						<a href="" class="ava male">
							<span class="icon-status status-online"></span>
							<img alt="" src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg">
						</a>
					</div>
					<div class="user-add-record_hold">
						<div class="user-add-record_tx">Я хочу добавить</div>
						<a href="#popup-user-add-article"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__article fancy-top">Статью</a>
						<a href="#popup-user-add-photo"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__photo fancy-top ">Фото</a>
						<a href="#popup-user-add-video"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__video fancy-top active">Видео</a>
						<a href="#popup-user-add-status"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__status fancy-top">Статус</a>
					</div>
				</div>
			</div>
		</div>

		<div class="content-cols clearfix">
			<div class="col-1">
				<div class="b-ava-large">
					<div class="b-ava-large_ava-hold clearfix">
						<a class="ava large" href="">
							<img alt="" src="/images/example/ava-large.jpg">
						</a>
						<span class="b-ava-large_online">На сайте</span>
						<a href="" class="b-ava-large_bubble b-ava-large_bubble__dialog powertip" title="Начать диалог">
							<span class="b-ava-large_ico b-ava-large_ico__mail"></span>
							<span class="b-ava-large_bubble-tx">+5</span>
						</a>
						<a href="" class="b-ava-large_bubble b-ava-large_bubble__photo powertip" title="Фотографии">
							<span class="b-ava-large_ico b-ava-large_ico__photo"></span>
							<span class="b-ava-large_bubble-tx">+50</span>
						</a>
						<a href="" class="b-ava-large_bubble b-ava-large_bubble__blog powertip" title="Записи в блоге">
							<span class="b-ava-large_ico b-ava-large_ico__blog"></span>
							<span class="b-ava-large_bubble-tx">+999</span>
						</a>
						<a href="" class="b-ava-large_bubble b-ava-large_bubble__friend-add-onhover powertip" title="Добавить в друзья">
							<span class="b-ava-large_ico b-ava-large_ico__friend-add"></span>
						</a>
					</div>
					<div class="textalign-c">
						<a href="" class="b-ava-large_a">Александр Богоявленский</a>
					</div>
				</div>
				
				<div class="aside-blog-desc">
					<div class="aside-blog-desc_tx">
						Пусть кто-то будет безумно красивый Пусть кто-то будет богаче и круче Мне наплевать, ведь ты - мой любимый.	Ты навсегда. Ты мой. Самый лучший.
					</div>
				</div>
			</div>
			<div class="col-23-middle col-gray">
				<div class="blog-title-b">
					<div class="blog-title-b_img-hold">
						<img src="/images/example/w720-h128.jpg" alt="" class="blog-title-b_img">
					</div>
					<h1 class="blog-title-b_t">Блог о красивой любви </h1>
				</div>
				
				<div class="b-article clearfix">
					<div class="float-l">
						<div class="like-control like-control__small-indent clearfix">
							<a href="" class="ava male">
								<span class="icon-status status-online"></span>
								<img alt="" src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg">
							</a>
						</div>
						<div class="js-like-control">
							<div class="like-control like-control__self clearfix">
								<div class="position-rel">
									<a href="" class="like-control_ico like-control_ico__like">865</a>
									<div class="favorites-add-popup favorites-add-popup__right">
										<div class="">Вы не можете ставить "Нравиться" к своей записи</div>
									</div>
								</div>
								<div class="position-rel">
									<a href="" class="like-control_ico like-control_ico__repost">5</a>
									<div class="favorites-add-popup favorites-add-popup__right">
										<div class="">Вы не можете делать репост своей записи</div>
									</div>
								</div>
								<div class="position-rel">
									<a href="" class="favorites-control_a">123865</a>
									<div class="favorites-add-popup favorites-add-popup__right">
										<div class="">Вы не можете добавить свою запись в Избранное</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="b-article_cont clearfix">
						<div class="b-article_cont-tale"></div>
						<div class="b-article_header clearfix">
							<div class="meta-gray">
								<a href="" class="meta-gray_comment">
									<span class="ico-comment ico-comment__gray"></span>
									<span class="meta-gray_tx">35</span>
								</a>
								<div class="meta-gray_view">
									<span class="ico-view ico-view__gray"></span>
									<span class="meta-gray_tx">305</span>
								</div>
							</div>
							<div class="float-l">
								<a href="" class="b-article_author">Ангелина Богоявленская</a>
								<span class="b-article_date">Сегодня 13:25</span>
							</div>
						</div>
						
						<h2 class="b-article_t">
							Самое лучшее утро - просыпаюсь, а ты рядом
						</h2>
						<div class="b-article_in clearfix">
							<div class="wysiwyg-content clearfix">
								
								<p>Практически нет девушки, которая не переживала бы за отношения героев "Сумерек" как в на экранах, так и в жизни. Но, к сожалению, даже несмотря на то, что недавно герои "Сумерек" радовали всех тем, что у них невероятный роман  и в рельной жизни, а не только лишь на экране, все же <a href="">Роберт Паттинсон</a>  и Кристен Стюарт расстались и пока решили взять паузу в своих отношениях.</p>
							</div>
						</div>
						<div class="custom-likes-b">
							<div class="custom-likes-b_slogan">Поделитесь с друзьями!</div>
							
							<a href="" class="custom-like">
								<span class="custom-like_icon odnoklassniki"></span>
								<span class="custom-like_value">0</span>
							</a>
							<a href="" class="custom-like">
								<span class="custom-like_icon vkontakte"></span>
								<span class="custom-like_value">1900</span>
							</a>
						
							<a href="" class="custom-like">
								<span class="custom-like_icon facebook"></span>
								<span class="custom-like_value">150</span>
							</a>
						
							<a href="" class="custom-like">
								<span class="custom-like_icon twitter"></span>
								<span class="custom-like_value">10</span>
							</a>
						</div>
						<div class="nav-article clearfix">
							<div class="nav-article_left">
								<a href="" class="nav-article_arrow nav-article_arrow__left"></a>
								<a href="" class="nav-article_a">Очень красивые пропорции у нашего ведущего</a>
							</div>
							<div class="nav-article_right">
								<a href="" class="nav-article_arrow nav-article_arrow__right"></a>
								<a href="" class="nav-article_a">Очень красивые пропорции Очень красивые пропорции у нашего ведущего у нашего ведущего</a>
							</div>
						</div>
						
						<div class="article-banner">
							<a href="">
								<img border="0" title="" alt="" src="/images/example/w540-h285.jpg">
							</a>
						</div>
						
						<div class="comments-gray">
							<div class="comments-gray_t">
								<span class="comments-gray_t-a-tx">Все комментарии (28)</span>
								<a href="" class="btn-green">Добавить</a>
							</div>
							<div class="comments-gray_hold">
								<div class="comments-gray_hold">
									<div class="comments-gray_i">
										<a href="" class="comments-gray_like like-hg-small powertip" title="Нравится">7918</a>
										<div class="comments-gray_ava">
											<a href="" class="ava small female"></a>
										</div>
										<div class="comments-gray_frame">
											<div class="comments-gray_header clearfix">
												<a href="" class="comments-gray_author">Анг Богоявлен </a>
												<span class="font-smallest color-gray">Сегодня 14:25</span>
											</div>
											<div class="comments-gray_cont wysiwyg-content">
												<p>я не нашел, где можно поменять название трека. </p>
											</div>
										</div>
										
										<div class="comments-gray_control">
											<div class="comments-gray_control-hold">
												<div class="clearfix">
													<a href="" class="comments-gray_quote-ico powertip" title="Ответить"></a>
												</div>
												<div class="clearfix">
													<a href="" class="message-ico message-ico__del powertip" title="Удалить"></a>
												</div>
											</div>
											<div class="clearfix">
												<a href="" class="message-ico message-ico__warning powertip" title="Пожаловаться"></a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="comments-gray_add clearfix">
								
								<div class="comments-gray_ava">
									<a href="" class="ava small female"></a>
								</div>
								<div class="comments-gray_frame">
									<input type="text" name="" id="" class="comments-gray_add-itx itx-gray" placeholder="Ваш комментарий">
								</div>
							</div>
						</div>
						<div class="position-rel">
							<br>
							<br>
							<br>
							<br>
							<br>
							
							<div class="redactor-popup" style="left:-25px;">
								<a href="" class="redactor-popup_close ico-close3 powertip" title="Закрыть"></a>
								<div class="redactor-popup_tale"></div>
								<div class="redactor-popup_t">Загрузите видео</div>
								<div class="redactor-popup_video clearfix">
									<a href="" class="redactor-popup_video-del ico-close powertip" title="Удалить"></a>
									<iframe width="540" height="300" frameborder="0" allowfullscreen="" src="http://www.youtube.com/embed/pehSAUTqjRs?wmode=transparent"></iframe>
								</div>
								<div class="redactor-popup_add-video active">
									<div class="redactor-popup_add-video-hold">
										<!-- При вводе текста убрать класс .btn-inactive с кнопки для ее активирования -->
										<input type="text" name="" id="" class="itx-simple w-350 float-l" placeholder="Введите ссылку на видео">
										<button class="btn-green btn-medium btn-inactive">Загрузить  видео</button>
									</div>
									<!-- При показе текстового сообщения на .redactor-popup_add-video добавлять класс .active -->
									<div class="redactor-popup_add-video-load">
										<img src="/images/ico/ajax-loader.gif" alt=""> <br>
										Подждите видео загружается
									</div>
								</div>
								<div class="redactor-popup_add-video active">
									<div class="redactor-popup_add-video-hold">
										<!-- При вводе текста убрать класс .btn-inactive с кнопки для ее активирования -->
										<input type="text" name="" id="" class="itx-simple w-350 float-l" placeholder="Введите ссылку на видео">
										<button class="btn-green btn-medium btn-inactive">Загрузить  видео</button>
									</div>
									<div class="redactor-popup_add-video-error">
										Не удалось загрузить видео. <br>
										Возможно, URL указан неправильно либо ведет на неподдерживаемый сайт.
									</div>
								</div>
								<div class="textalign-c margin-t15">
									<a href="" class="btn-gray-light btn-medium margin-r10">Отменить</a>
									<a href="" class="btn-green btn-medium btn-inactive">Добавить видео</a>
								</div>
							</div>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<div class="redactor-popup">
								<a href="" class="redactor-popup_close ico-close3 powertip" title="Закрыть"></a>
								<div class="redactor-popup_tale"></div>
								<div class="redactor-popup_t">Выберите смайл</div>
								<table class="redactor-popup_smiles">
									<tbody>
										<tr>
											<td><a href=""><img src="/images/widget/smiles/acute (1).gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/acute.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/air_kiss.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/angel.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/bad.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/beach.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/beee.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/blush2.gif"></a></td>
										</tr>
										<tr>
											<td><a href=""><img src="/images/widget/smiles/Cherna-girl_on_weight.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/connie_1.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/connie_33.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/connie_36.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/connie_6.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/connie_feedbaby.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/cray.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/dance.gif"></a></td>
										</tr>
										<tr>
											<td><a href=""><img src="/images/widget/smiles/dash2.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/diablo.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/dirol.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/dntknw.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/drinks.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/d_coffee.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/d_lovers.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/facepalm.gif"></a></td>
										</tr>
										<tr>
											<td><a href=""><img src="/images/widget/smiles/fie.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/first_move.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/fool.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/girl_cray2.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/girl_dance.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/girl_drink1.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/girl_hospital.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/girl_prepare_fish.gif"></a></td>
										</tr>
										<tr>
											<td><a href=""><img src="/images/widget/smiles/girl_sigh.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/girl_wink.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/girl_witch.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/give_rose.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/good.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/help.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/JC_hiya.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/JC_hulahoop-girl.gif"></a></td>
										</tr>
										<tr>
											<td><a href=""><img src="/images/widget/smiles/kirtsun_05.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/kuzya_01.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/LaieA_052.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/Laie_16.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/Laie_50.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/Laie_7.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/lazy2.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/l_moto.gif"></a></td>
										</tr>
										<tr>
											<td><a href=""><img src="/images/widget/smiles/mail1.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/Mauridia_21.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/mosking.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/music2.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/negative.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/pardon.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/phil_05.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/phil_35.gif"></a></td>
										</tr>
										<tr>
											<td><a href=""><img src="/images/widget/smiles/popcorm1.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/preved.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/rofl.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/sad.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/scratch_one-s_head.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/secret.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/shok.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/smile3.gif"></a></td>
										</tr>
										<tr>
											<td><a href=""><img src="/images/widget/smiles/sorry.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/tease.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/to_become_senile.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/viannen_10.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/wacko2.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/wink.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/yahoo.gif"></a></td>
											<td><a href=""><img src="/images/widget/smiles/yes3.gif"></a></td>
										</tr>
									</tbody>
								</table>
							</div>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<div class="redactor-popup" style="left:-25px;">
								<a href="" class="redactor-popup_close ico-close3 powertip" title="Закрыть"></a>
								<div class="redactor-popup_tale"></div>
								<div class="redactor-popup_t">Загрузите фото</div>
								<!-- .dragover - класс добавлять, когда курсор мыши с файлами находится над блоком -->
								<div class="b-add-img b-add-img__for-single dragover">
									<div class="b-add-img_hold">
										<div class="b-add-img_t">
											Загрузите фотографии с компьютера
											<div class="b-add-img_t-tx">Поддерживаемые форматы: jpg и png</div>
										</div>
										<div class="file-fake">
											<button class="btn-green btn-medium file-fake_btn">Обзор</button>
											<input type="file" name="">
										</div>
									</div>
									<div class="b-add-img_html5-tx">или перетащите фото сюда</div>
								</div>
								<div class="textalign-c margin-t15">
									<a href="" class="btn-gray-light btn-medium margin-r10">Отменить</a>
									<a href="" class="btn-green btn-medium btn-inactive">Добавить видео</a>
								</div>
							</div>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<div class="redactor-popup" style="left:-25px;">
								<a href="" class="redactor-popup_close ico-close3 powertip" title="Закрыть"></a>
								<div class="redactor-popup_tale"></div>
								<div class="redactor-popup_t">Загрузите фото</div>
								<div class="b-add-img b-add-img__single">
									<div class="b-add-img_hold">
										<div class="b-add-img_t">
											Загрузите фотографии с компьютера
											<div class="b-add-img_t-tx">Поддерживаемые форматы: jpg и png</div>
										</div>
										<div class="file-fake">
											<button class="btn-green btn-medium file-fake_btn btn-inactive">Обзор</button>
											<input type="file" name="">
										</div>
									</div>
									<div class="textalign-c clearfix">
										<div class="b-add-img_i b-add-img_i__single">
											<img class="b-add-img_i-img" src="/images/example/w440-h340.jpg" alt="">
											<div class="b-add-img_i-vert"></div>
											<div class="b-add-img_i-overlay">
												<a href="" class="b-add-img_i-del ico-close4"></a>
											</div>
										</div>
									</div>
									<!-- Текст приглашения для перетаскивания можно скрыть или удалить при наличии фото -->
									<div class="b-add-img_html5-tx display-n">или перетащите фото сюда</div>
								</div>
								<div class="textalign-c margin-t15">
									<a href="" class="btn-gray-light btn-medium margin-r10">Отменить</a>
									<a href="" class="btn-green btn-medium">Добавить видео</a>
								</div>
							</div>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<div class="redactor-popup redactor-popup_b-link">
								<a href="" class="redactor-popup_close ico-close3 powertip" title="Закрыть"></a>
								<div class="redactor-popup_tale"></div>
								<div class="redactor-popup_t">Ссылка</div>
								
								<div class="redactor-popup_holder-blue">
									<div class="margin-b10 clearfix">
										<label class="redactor-popup_label" for="">Отображаемый текст</label>
										<div class="float-l w-350">
											<input type="text" placeholder="Введите текст" class="itx-simple" id="" name="" value="Выделенный текст">
										</div>
									</div>
									<div class="clearfix">
										<label class="redactor-popup_label" for="">Ссылка на</label>
										<div class="float-l w-350 error">
											<input type="text" placeholder="Введите URL страницы" class="itx-simple" id="" name="">
											<div class="errorMessage">Необходимо заполнить поле URL страницы.</div>
										</div>
									</div>
								</div>
								
								<div class="textalign-c margin-t15">
									<a href="" class="btn-gray-light btn-medium margin-r10">Отменить</a>
									<a href="" class="btn-green btn-medium">Добавить ссылку</a>
								</div>
							</div>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
						</div>
					</div>
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
	<!-- popup-user-add-article -->
	<div id="popup-user-add-article" class="popup-user-add-record">
		<a class="popup-transparent-close" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
		<div class="clearfix">
			<div class="w-720 float-r">
				
				<div class="user-add-record user-add-record__yellow clearfix">
					<div class="user-add-record_ava-hold">
						<a href="" class="ava male">
							<span class="icon-status status-online"></span>
							<img alt="" src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg">
						</a>
					</div>
					<div class="user-add-record_hold">
						<div class="user-add-record_tx">Я хочу добавить</div>
						<a href="#popup-user-add-article" class="user-add-record_ico user-add-record_ico__article active fancy-top">Статью</a>
						<a href="#popup-user-add-photo" class="user-add-record_ico user-add-record_ico__photo fancy-top">Фото</a>
						<a href="#popup-user-add-video" class="user-add-record_ico user-add-record_ico__video fancy-top">Видео</a>
						<a href="#popup-user-add-status"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__status fancy-top">Статус</a>
					</div>
				</div>
				
				<div class="b-settings-blue b-settings-blue__article">
					<div class="b-settings-blue_tale"></div>
					<div class="b-settings-blue_head">
						<div class="b-settings-blue_row clearfix">
							<div class="clearfix margin-t-10">
								<div class="float-r font-small color-gray margin-3">0/50</div>
							</div>
							<label for="" class="b-settings-blue_label">Заголовок</label>
							<div class="float-l w-400">
								<input type="text" name="" id="" class="itx-simple" placeholder="Введите заголовок видео">
								<div class="errorMessage">Необходимо заполнить поле Заголовок.</div>
							</div>
						</div>
						<div class="b-settings-blue_row clearfix">
							<label for="" class="b-settings-blue_label">Рубрика</label>
							<div class="w-400 float-l">
								<div class="chzn-itx-simple">
									<select class="chzn" data-placeholder="Выберите рубрику">
										<option></option>
										<option>Россия</option>
										<option>2</option>
										<option>32</option>						
										<option>32</option>						
										<option>32</option>						
										<option>32</option>						
										<option>132</option>						
										<option>132</option>						
										<option>132</option>						
									</select>
									<!--
									<div class='chzn-itx-simple_add clearfix'>
										<button class='btn-green'>Ok</button>
										<div class='chzn-itx-simple_add-hold'>
											<input type='text' name='' id='' class='chzn-itx-simple_add-itx' placeholder="Создать новую рубрику">
											<a href='' class='chzn-itx-simple_add-del'></a>
										</div>
									</div>
									-->
								</div>
								<div class="b-settings-blue_row-desc">Если вы не выберете рубрику, запись добавится в рубрику "Обо всем"</div>
							</div>
						</div>
					</div>
					
					<div class="wysiwyg-v wysiwyg-blue clearfix">
						<script src="/redactor/plugins/toolbarVerticalFixed/toolbarVerticalFixed.js"></script>	
						<script>
							$(document).ready(function () { 
							  $('.wysiwyg-redactor-v').redactor({
							      plugins: ['toolbarVerticalFixed'],
							      minHeight: 410,
							      autoresize: true,
							      toolbarExternal: '.wysiwyg-toolbar-btn',

							      /* В базовом варианте нет кнопок 'h2', 'h3', 'link_add', 'link_del' но их функции реализованы с помощью выпадающих списков */
							      buttons: ['bold', 'italic', 'underline', 'deleted', 'h2', 'h3', 'unorderedlist', 'orderedlist', 'link_add', 'link_del', 'image', 'video', 'smile'],
							      buttonsCustom: {
							          smile: {
							              title: 'smile',
							              callback: function(buttonName, buttonDOM, buttonObject) {
							                  // your code, for example - getting code
							                  var html = this.get();
							              }
							          },
							          link_add: {
							              title: 'link_add',
							              callback: function(buttonName, buttonDOM, buttonObject) {
							                  // your code, for example - getting code
							                  var html = this.get();
							              }
							          },
							          link_del: {
							              title: 'link_del',
							              callback: function(buttonName, buttonDOM, buttonObject) {
							                  // your code, for example - getting code
							                  var html = this.get();
							              }
							          },
							          h2: {
							              title: 'h2',
							              callback: function(buttonName, buttonDOM, buttonObject) {
							                  // your code, for example - getting code
							                  var html = this.get();
							              }
							          },
							          h3: {
							              title: 'h3',
							              callback: function(buttonName, buttonDOM, buttonObject) {
							                  // your code, for example - getting code
							                  var html = this.get();
							              }
							          }
							      }
							  });
							});
						</script>
					<div class="wysiwyg-toolbar">
						<div class="wysiwyg-toolbar-btn"></div>
					</div>
						<textarea name="" class="wysiwyg-redactor-v"></textarea>
					</div>
					
					<div class="clearfix textalign-r">
						<div style="" class="errorSummary" id="blog-form_es_">
							<p>Необходимо исправить следующие ошибки:</p>
							<ul>
								<li>Необходимо заполнить поле Заголовок.</li>
								<li>Необходимо заполнить поле Текст.</li>
							</ul>
						</div>
					</div>
					
					<div class=" clearfix">
						<a href="" class="btn-blue btn-h46 float-r">Добавить</a>
						<a href="" class="btn-gray-light btn-h46 float-r margin-r15">Отменить</a>
						
						<div class="float-l margin-l65">
							<div class="privacy-select clearfix">
								<div class="privacy-select_hold clearfix">
									<div class="privacy-select_tx">Для кого:</div>
									<div class="privacy-select_drop-hold">
										<a href="" class="privacy-select_a">
											<span class="ico-users ico-users__friend active"></span>
											<span class="privacy-select_a-tx">только <br>друзьям</span>
										</a>
									</div>
									<div class="privacy-select_drop">
										<div class="privacy-select_i">
											<a href="" class="privacy-select_a">
											<span class="ico-users ico-users__all"></span>
											<span class="privacy-select_a-tx">для <br>всех</span>
											</a>
										</div>
										<div class="privacy-select_i">
											<a href="" class="privacy-select_a">
											<span class="ico-users ico-users__friend"></span>
											<span class="privacy-select_a-tx">только <br>друзьям</span>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /popup-user-add-article -->
	
	<!-- popup-user-add-video -->
	<div id="popup-user-add-video" class="popup-user-add-record">
		<a class="popup-transparent-close" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
		<div class="clearfix">
			<div class="w-720 float-r">
				
				<div class="user-add-record user-add-record__yellow clearfix">
					<div class="user-add-record_ava-hold">
						<a href="" class="ava male">
							<span class="icon-status status-online"></span>
							<img alt="" src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg">
						</a>
					</div>
					<div class="user-add-record_hold">
						<div class="user-add-record_tx">Я хочу добавить</div>
						<a href="#popup-user-add-article" class="user-add-record_ico user-add-record_ico__article fancy-top">Статью</a>
						<a href="#popup-user-add-photo" class="user-add-record_ico user-add-record_ico__photo fancy-top">Фото</a>
						<a href="#popup-user-add-video" class="user-add-record_ico user-add-record_ico__video active fancy-top">Видео</a>
						<a href="#popup-user-add-status"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__status fancy-top">Статус</a>
					</div>
				</div>
				
				<div class="b-settings-blue b-settings-blue__video">
					<div class="b-settings-blue_tale"></div>
					<div class="b-settings-blue_head">
						<div class="b-settings-blue_row clearfix">
							<div class="clearfix margin-t-10">
								<div class="float-r font-small color-gray margin-3">0/50</div>
							</div>
							<label for="" class="b-settings-blue_label">Заголовок</label>
							<div class="w-400  float-l error">
								<input type="text" name="" id="" class="itx-simple" placeholder="Введите заголовок видео">
								<div class="errorMessage">Введите заголовок</div>
							</div>
						</div>
						<div class="b-settings-blue_row clearfix">
							<label for="" class="b-settings-blue_label">Рубрика</label>
							<div class="w-400 float-l error">
								<div class="chzn-itx-simple">
									<select class="chzn">
										<option selected="selected">0</option>
										<option>Россия</option>
										<option>2</option>						
									</select>
									<!--
									<div class='chzn-itx-simple_add clearfix'>
										<button class='btn-green'>Ok</button>
										<div class='chzn-itx-simple_add-hold'>
											<input type='text' name='' id='' class='chzn-itx-simple_add-itx'>
											<a href='' class='chzn-itx-simple_add-del'></a>
										</div>
									</div>
									-->
								</div>
								<div class="errorMessage">Введите рубрику</div>
							</div>
						</div>
					</div>
					<div class="b-settings-blue_add-video clearfix">
						<!-- При вводе текста убрать класс .btn-inactive с кнопки для ее активирования -->
						<input type="text" name="" id="" class="itx-simple w-400 float-l" placeholder="Введите ссылку на видео">
						<button class="btn-green btn-inactive">Загрузить  видео</button>
						<div class="b-settings-blue_add-video-load">
							<img src="/images/ico/ajax-loader.gif" alt=""> <br>
							Подждите видео загружается
						</div>
					</div>
					<div class="b-settings-blue_add-video clearfix">
						<!-- При вводе текста убрать класс .btn-inactive с кнопки для ее активирования -->
						<input type="text" name="" id="" class="itx-simple w-400 float-l" placeholder="Введите ссылку на видео">
						<button class="btn-green btn-inactive">Загрузить  видео</button>
						<div class="errorMessage">
							Не удалось загрузить видео. <br>
							Возможно, URL указан неправильно либо ведет на неподдерживаемый сайт.
						</div>
					</div>
					<div class="b-settings-blue_video clearfix">
						<a href="" class="b-settings-blue_video-del ico-close2 powertip" title="Удалить"></a>
						<iframe width="580" height="320" frameborder="0" allowfullscreen="" src="http://www.youtube.com/embed/pehSAUTqjRs?wmode=transparent"></iframe>
					</div>
					<div class="b-settings-blue_row clearfix">
						<textarea name="" id="" cols="80" rows="5" class="b-settings-blue_textarea itx-simple" placeholder="Ваш комментарий"></textarea>
					</div>
					<div class=" clearfix">
						<a href="" class="btn-blue btn-h46 float-r btn-inactive">Добавить</a>
						<a href="" class="btn-gray-light btn-h46 float-r margin-r15">Отменить</a>
						
						<div class="float-l">
							<div class="privacy-select clearfix">
								<div class="privacy-select_hold clearfix">
									<div class="privacy-select_tx">Для кого:</div>
									<div class="privacy-select_drop-hold">
										<a href="" class="privacy-select_a">
											<span class="ico-users ico-users__friend active"></span>
											<span class="privacy-select_a-tx">только <br>друзьям</span>
										</a>
									</div>
									<div class="privacy-select_drop display-b">
										<div class="privacy-select_i">
											<a href="" class="privacy-select_a">
											<span class="ico-users ico-users__all"></span>
											<span class="privacy-select_a-tx">для <br>всех</span>
											</a>
										</div>
										<div class="privacy-select_i">
											<a href="" class="privacy-select_a">
											<span class="ico-users ico-users__friend"></span>
											<span class="privacy-select_a-tx">только <br>друзьям</span>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /popup-user-add-video -->
	
	<!-- popup-user-add-photo -->
	<div id="popup-user-add-photo" class="popup-user-add-record">
		<a class="popup-transparent-close" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
		<div class="clearfix">
			<div class="w-720 float-r">
				
				<div class="user-add-record user-add-record__yellow clearfix">
					<div class="user-add-record_ava-hold">
						<a href="" class="ava male">
							<span class="icon-status status-online"></span>
							<img alt="" src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg">
						</a>
					</div>
					<div class="user-add-record_hold">
						<div class="user-add-record_tx">Я хочу добавить</div>
						<a href="#popup-user-add-article" class="user-add-record_ico user-add-record_ico__article fancy-top">Статью</a>
						<a href="#popup-user-add-photo" class="user-add-record_ico user-add-record_ico__photo active fancy-top">Фото</a>
						<a href="#popup-user-add-video" class="user-add-record_ico user-add-record_ico__video fancy-top">Видео</a>
						<a href="#popup-user-add-status"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__status fancy-top">Статус</a>
					</div>
				</div>
				
				<div class="b-settings-blue b-settings-blue__photo">
					<div class="b-settings-blue_tale"></div>
					<div class="clearfix">
						<div class="b-settings-blue_photo-record">
							<div class="b-settings-blue_photo-record-t">Личные <br> фотоальбомы</div>
							<div class="b-settings-blue_photo-record-img">
								<img src="/images/b-settings-blue_photo-record-img1.png" alt="" class="">
							</div>
							<div class="clearfix">
								<a href="" class="btn-blue btn-h46">Загрузить фото</a>
							</div>
						</div>
						<div class="b-settings-blue_photo-record">
							<div class="b-settings-blue_photo-record-t">Фотопост <br> в блоге</div>
							<div class="b-settings-blue_photo-record-img">
								<img src="/images/b-settings-blue_photo-record-img2.png" alt="" class="">
							</div>
							<div class="clearfix">
								<a href="" class="btn-blue btn-h46">Создать фотопост</a>
							</div>
						</div>
						
					</div>
				</div>
				
				<div class="b-settings-blue b-settings-blue__photo display-n">
					<div class="b-settings-blue_tale"></div>
					<div class="b-settings-blue_head">
						<div class="b-settings-blue_row clearfix">
							<div class="clearfix">
								<div class="float-r font-small color-gray margin-3">0/50</div>
							</div>
							<label for="" class="b-settings-blue_label">Заголовок</label>
							<div class="float-l w-400">
								<input type="text" name="" id="" class="itx-simple w-400" placeholder="Введите заголовок фото">
							</div>
						</div>
						<div class="b-settings-blue_row clearfix">
							<label for="" class="b-settings-blue_label">Рубрика</label>
							<div class="w-400 float-l">
								<div class="chzn-itx-simple">
									<select class="chzn" data-placeholder="Выберите рубрику">
										<option></option>
										<option>Россия</option>
										<option>2</option>
										<option>32</option>						
										<option>32</option>						
										<option>32</option>						
										<option>32</option>						
										<option>132</option>						
										<option>132</option>						
										<option>132</option>						
									</select>
									<!--
									<div class='chzn-itx-simple_add clearfix'>
										<button class='btn-green'>Ok</button>
										<div class='chzn-itx-simple_add-hold'>
											<input type='text' name='' id='' class='chzn-itx-simple_add-itx'>
											<a href='' class='chzn-itx-simple_add-del'></a>
										</div>
									</div>
									-->
								</div>
							</div>
						</div>
					</div>
					
					
					<!-- .dragover - класс добавлять, когда курсер мыши с файлами находится над блоком -->
					<div class="b-add-img b-add-img__for-multi">
						<div class="b-add-img_hold">
							<div class="b-add-img_t">
								Загрузите фотографии с компьютера
								<div class="b-add-img_t-tx">Поддерживаемые форматы: jpg и png</div>
							</div>
							<div class="file-fake">
								<button class="btn-green btn-medium file-fake_btn">Обзор</button>
								<input type="file" name="">
							</div>
						</div>
						<div class="b-add-img_html5-tx">или перетащите фото сюда</div>
					</div>
					
					<div class="b-settings-blue_row clearfix">
						<textarea name="" id="" cols="80" rows="5" class="b-settings-blue_textarea itx-simple" placeholder="Ваш текст к фотопосту "></textarea>
					</div>
					<div class=" clearfix">
						<a href="" class="btn-blue btn-h46 float-r btn-inactive">Добавить</a>
						<a href="" class="btn-gray-light btn-h46 float-r margin-r15">Отменить</a>
						
						<div class="float-l">
							<div class="privacy-select clearfix">
								<div class="privacy-select_hold clearfix">
									<div class="privacy-select_tx">Для кого:</div>
									<div class="privacy-select_drop-hold">
										<a href="" class="privacy-select_a">
											<span class="ico-users ico-users__friend active"></span>
											<span class="privacy-select_a-tx">только <br>друзьям</span>
										</a>
									</div>
									<div class="privacy-select_drop">
										<div class="privacy-select_i">
											<a href="" class="privacy-select_a">
											<span class="ico-users ico-users__all"></span>
											<span class="privacy-select_a-tx">для <br>всех</span>
											</a>
										</div>
										<div class="privacy-select_i">
											<a href="" class="privacy-select_a">
											<span class="ico-users ico-users__friend"></span>
											<span class="privacy-select_a-tx">только <br>друзьям</span>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="b-settings-blue b-settings-blue__photo display-n">
					<div class="b-settings-blue_tale"></div>
					<div class="b-settings-blue_head">
						<div class="b-settings-blue_row clearfix">
							<label for="" class="b-settings-blue_label">Фотоальбом</label>
							<div class="w-400 float-l">
								<div class="chzn-itx-simple">
									<select class="chzn" data-placeholder="Выберите рубрику">
										<option></option>
										<option>Россия</option>
										<option>2</option>
										<option>32</option>						
										<option>32</option>						
										<option>32</option>						
										<option>32</option>						
										<option>132</option>						
										<option>132</option>						
										<option>132</option>						
									</select>
									<!--
									<div class='chzn-itx-simple_add clearfix'>
										<button class='btn-green'>Ok</button>
										<div class='chzn-itx-simple_add-hold'>
											<input type='text' name='' id='' class='chzn-itx-simple_add-itx'>
											<a href='' class='chzn-itx-simple_add-del'></a>
										</div>
									</div>
									-->
								</div>
							</div>
						</div>
					</div>
							
					<div class="b-add-img b-add-img__single">
						<div class="b-add-img_hold">
							<div class="b-add-img_t">
								Загрузите фотографии с компьютера
								<div class="b-add-img_t-tx">Поддерживаемые форматы: jpg и png</div>
							</div>
							<div class="file-fake">
								<button class="btn-green btn-medium file-fake_btn">Обзор</button>
								<input type="file" name="">
							</div>
						</div>
						<div class="textalign-c clearfix">
							<div class="b-add-img_i b-add-img_i__single">
								<img class="b-add-img_i-img" src="/images/example/w440-h340.jpg" alt="">
								<div class="b-add-img_i-vert"></div>
								<div class="b-add-img_i-overlay">
									<a href="" class="b-add-img_i-del ico-close4"></a>
								</div>
							</div>
						</div>
						<!-- Текст приглашения для перетаскивания можно скрыть или удалить при наличии фото -->
						<div class="b-add-img_html5-tx display-n">или перетащите фото сюда</div>
					</div>
					
					<div class=" clearfix">
						<a href="" class="btn-blue btn-h46 float-r">Добавить</a>
						<a href="" class="btn-gray-light btn-h46 float-r margin-r15">Отменить</a>
						
						<div class="float-l">
							<div class="privacy-select clearfix">
								<div class="privacy-select_hold clearfix">
									<div class="privacy-select_tx">Для кого:</div>
									<div class="privacy-select_drop-hold">
										<a href="" class="privacy-select_a">
											<span class="ico-users ico-users__friend active"></span>
											<span class="privacy-select_a-tx">только <br>друзьям</span>
										</a>
									</div>
									<div class="privacy-select_drop display-b">
										<div class="privacy-select_i">
											<a href="" class="privacy-select_a">
											<span class="ico-users ico-users__all"></span>
											<span class="privacy-select_a-tx">для <br>всех</span>
											</a>
										</div>
										<div class="privacy-select_i">
											<a href="" class="privacy-select_a">
											<span class="ico-users ico-users__friend"></span>
											<span class="privacy-select_a-tx">только <br>друзьям</span>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="b-settings-blue b-settings-blue__photo display-n">
					<div class="b-settings-blue_tale"></div>
					<div class="b-settings-blue_head">
						<div class="b-settings-blue_row clearfix">
							<label for="" class="b-settings-blue_label">Фотоальбом</label>
							<div class="w-400 float-l">
								<div class="chzn-itx-simple">
									<select class="chzn" data-placeholder="Выберите или создайте рубрику">
										<option></option>
										<option>Россия</option>
										<option>2</option>
										<option>32</option>						
										<option>32</option>						
										<option>32</option>						
										<option>32</option>						
										<option>132</option>						
										<option>132</option>						
										<option>132</option>						
									</select>
									<!--
									<div class='chzn-itx-simple_add clearfix'>
										<button class='btn-green'>Ok</button>
										<div class='chzn-itx-simple_add-hold'>
											<input type='text' name='' id='' class='chzn-itx-simple_add-itx'>
											<a href='' class='chzn-itx-simple_add-del'></a>
										</div>
									</div>
									-->
								</div>
							</div>
						</div>
					</div>
							
					<div class="b-add-img b-add-img__for-multi">
						<div class="b-add-img_hold">
							<div class="b-add-img_t">
								Загрузите фотографии с компьютера
								<div class="b-add-img_t-tx">Поддерживаемые форматы: jpg и png</div>
							</div>
							<div class="file-fake">
								<button class="btn-green btn-medium file-fake_btn">Обзор</button>
								<input type="file" name="">
							</div>
						</div>
						<div class="textalign-c clearfix">
							<div class="b-add-img_i">
								<img class="b-add-img_i-img" src="/images/example/w440-h340.jpg" alt="">
								<!-- b-add-img_i-vert для вертикального позиционирования маленькой каритнки -->
								<div class="b-add-img_i-vert"></div>
								<div class="b-add-img_i-overlay">
									<a href="" class="b-add-img_i-del ico-close4"></a>
								</div>
							</div>
							<div class="b-add-img_i">
								<img class="b-add-img_i-img" src="/images/example/w64-h61-2.jpg" alt="">
								<div class="b-add-img_i-vert"></div>
								<div class="b-add-img_i-overlay">
									<a href="" class="b-add-img_i-del ico-close4"></a>
								</div>
							</div>
							<div class="b-add-img_i">
								<img class="b-add-img_i-img" src="/images/example/11.jpg" alt="">
								<div class="b-add-img_i-vert"></div>
								<div class="b-add-img_i-overlay">
									<a href="" class="b-add-img_i-del ico-close4"></a>
								</div>
							</div>
							<div class="b-add-img_i">
								<img class="b-add-img_i-img" src="/images/example/w220-h309-1.jpg" alt="">
								<div class="b-add-img_i-vert"></div>
								<div class="b-add-img_i-overlay">
									<a href="" class="b-add-img_i-del ico-close4"></a>
								</div>
							</div>
							<div class="b-add-img_i">
								<img class="b-add-img_i-img" src="/images/example/w720-h128.jpg" alt="">
								<div class="b-add-img_i-vert"></div>
								<div class="b-add-img_i-overlay">
									<a href="" class="b-add-img_i-del ico-close4"></a>
								</div>
							</div>
							<div class="b-add-img_i error">
								<div class="b-add-img_i-error-tx">файл мотик.jpg не удалось загрузить, более 10 Мб</div>
								<div class="b-add-img_i-vert"></div>
								<div class="b-add-img_i-overlay">
									<a href="" class="b-add-img_i-del ico-close4"></a>
								</div>
							</div>
							<div class="b-add-img_i">
								<img class="b-add-img_i-img opacity-20" src="/images/example/w720-h128.jpg" alt="">
								<div class="b-add-img_i-vert"></div>
								<div class="b-add-img_i-load">
									<div class="b-add-img_i-load-progress" style="width:20%;"></div>
								</div>
								<div class="b-add-img_i-overlay">
									<a href="" class="b-add-img_i-del ico-close4"></a>
								</div>
							</div>
						</div>
						<!-- Текст приглашения для перетаскивания можно скрыть или удалить при наличии фото -->
						<div class="b-add-img_html5-tx display-n">или перетащите фото сюда</div>
					</div>
					
					<div class=" clearfix">
						<a href="" class="btn-blue btn-h46 float-r">Добавить</a>
						<a href="" class="btn-gray-light btn-h46 float-r margin-r15">Отменить</a>
						
						<div class="float-l">
							<div class="privacy-select clearfix">
								<div class="privacy-select_hold clearfix">
									<div class="privacy-select_tx">Для кого:</div>
									<div class="privacy-select_drop-hold">
										<a href="" class="privacy-select_a">
											<span class="ico-users ico-users__friend active"></span>
											<span class="privacy-select_a-tx">только <br>друзьям</span>
										</a>
									</div>
									<div class="privacy-select_drop display-b">
										<div class="privacy-select_i">
											<a href="" class="privacy-select_a">
											<span class="ico-users ico-users__all"></span>
											<span class="privacy-select_a-tx">для <br>всех</span>
											</a>
										</div>
										<div class="privacy-select_i">
											<a href="" class="privacy-select_a">
											<span class="ico-users ico-users__friend"></span>
											<span class="privacy-select_a-tx">только <br>друзьям</span>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /popup-user-add-photo -->
	
	
	<!-- popup-user-add-status -->
	<div id="popup-user-add-status" class="popup-user-add-record">
		<a class="popup-transparent-close" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
		<div class="clearfix">
			<div class="w-720 float-r">
				
				<div class="user-add-record user-add-record__yellow clearfix">
					<div class="user-add-record_ava-hold">
						<a href="" class="ava male">
							<span class="icon-status status-online"></span>
							<img alt="" src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg">
						</a>
					</div>
					<div class="user-add-record_hold">
						<div class="user-add-record_tx">Я хочу добавить</div>
						<a href="#popup-user-add-article" class="user-add-record_ico user-add-record_ico__article fancy-top">Статью</a>
						<a href="#popup-user-add-photo" class="user-add-record_ico user-add-record_ico__photo fancy-top">Фото</a>
						<a href="#popup-user-add-video" class="user-add-record_ico user-add-record_ico__video fancy-top">Видео</a>
						<a href="#popup-user-add-status"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__status active fancy-top">Статус</a>
					</div>
				</div>
				
				<div class="b-settings-blue b-settings-blue__status">
					<div class="b-settings-blue_tale"></div>
					
					<div class="b-status-add clearfix">
						<div class="float-l">
							<a class="ava male" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg" alt="">
							</a>
						</div>
						<div class="b-status-add_col">
							<div class="b-status-add_hold">
								<div class="clearfix">
									<div class="float-r font-small color-gray">50/250</div>
								</div>
								<textarea name="" id="" cols="60" rows="3" class="b-status-add_textarea"></textarea>
							</div>
							<div class="margin-b10 clearfix">
								<div class="b-user-mood">
									<div class="b-user-mood_img">
										<img src="/images/widget/mood/0.png">
									</div>
									<div class="b-user-mood_hold">
										<a href="" class="a-pseudo">Прикрепить <br> мое настроение</a>
									</div>
								</div>
								
							</div>
						
							<div class=" clearfix">
								<a href="" class="btn-blue btn-h46 float-r btn-inactive">Добавить</a>
								<a href="" class="btn-gray-light btn-h46 float-r margin-r15">Отменить</a>
								
								<div class="float-l">
									<div class="privacy-select clearfix">
										<div class="privacy-select_hold clearfix">
											<div class="privacy-select_tx">Для кого:</div>
											<div class="privacy-select_drop-hold">
												<a href="" class="privacy-select_a">
													<span class="ico-users ico-users__friend active"></span>
													<span class="privacy-select_a-tx">только <br>друзьям</span>
												</a>
											</div>
											<div class="privacy-select_drop">
												<div class="privacy-select_i">
													<a href="" class="privacy-select_a">
													<span class="ico-users ico-users__all"></span>
													<span class="privacy-select_a-tx">для <br>всех</span>
													</a>
												</div>
												<div class="privacy-select_i">
													<a href="" class="privacy-select_a">
													<span class="ico-users ico-users__friend"></span>
													<span class="privacy-select_a-tx">только <br>друзьям</span>
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div>
				
				<div class="b-settings-blue b-settings-blue__status display-n">
					<div class="b-settings-blue_tale"></div>
					
					<div class="b-status-add clearfix">
						<div class="float-l">
							<a class="ava male" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg" alt="">
							</a>
						</div>
						<div class="b-status-add_col">
							<div class="b-status-add_hold">
								<div class="clearfix">
									<div class="float-r font-small color-gray">50/250</div>
								</div>
								<textarea name="" id="" cols="60" rows="3" class="b-status-add_textarea"></textarea>
							</div>
							<div class="margin-b10 clearfix">
								<div class="b-user-mood">
									<div class="b-user-mood_img">
										<img src="/images/widget/mood/6.png">
									</div>
									<div class="b-user-mood_hold">
										<div class="b-user-mood_tx">- мое настроение</div>
										<a href="" class="a-pseudo font-small margin-l10">Изменить</a> &nbsp;
										<a href="" class="a-pseudo-gray font-small">Удалить</a>
									</div>
								</div>
							</div>
						
							<div class=" clearfix">
								<a href="" class="btn-blue btn-h46 float-r btn-inactive">Добавить</a>
								<a href="" class="btn-gray-light btn-h46 float-r margin-r15">Отменить</a>
								
								<div class="float-l">
									<div class="privacy-select clearfix">
										<div class="privacy-select_hold clearfix">
											<div class="privacy-select_tx">Для кого:</div>
											<div class="privacy-select_drop-hold">
												<a href="" class="privacy-select_a">
													<span class="ico-users ico-users__friend active"></span>
													<span class="privacy-select_a-tx">только <br>друзьям</span>
												</a>
											</div>
											<div class="privacy-select_drop">
												<div class="privacy-select_i">
													<a href="" class="privacy-select_a">
													<span class="ico-users ico-users__all"></span>
													<span class="privacy-select_a-tx">для <br>всех</span>
													</a>
												</div>
												<div class="privacy-select_i">
													<a href="" class="privacy-select_a">
													<span class="ico-users ico-users__friend"></span>
													<span class="privacy-select_a-tx">только <br>друзьям</span>
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div>
				
				<div class="b-settings-blue b-settings-blue__status display-n">
					<div class="b-settings-blue_tale"></div>
					
					<div class="b-status-add clearfix">
						<div class="float-l">
							<a class="ava male" href="">
								<span class="icon-status status-online"></span>
								<img src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg" alt="">
							</a>
						</div>
						<div class="b-status-add_col">
							<div class="b-status-add_hold">
								<div class="clearfix">
									<div class="float-r font-small color-gray">50/250</div>
								</div>
								<textarea name="" id="" cols="60" rows="3" class="b-status-add_textarea"></textarea>
							</div>
							<div class="margin-b10 clearfix">
								<div class="b-user-mood">
									<div class="b-user-mood_img">
										<div class="position-rel">
											<div class="b-moods-list" style="display: block;">
												<ul class="b-moods-list_ul">
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/1.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Ем</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/2.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Испуг</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/3.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Грустный</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/4.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Молчу</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/5.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Подозрительно</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/6.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Интересно</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/7.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Все ОК</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/8.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Голова кругом</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/9.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Любовь</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/10.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Подарок</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/11.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Красотка</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/12.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Радость</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/13.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Задумался</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/14.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Смущаюсь</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/15.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Праздник</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/16.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Стреляюсь</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/17.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Драка</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/18.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Отстой</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/19.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Смешно</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/20.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Улыбаюсь</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/21.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Шопинг</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/22.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Напеваю</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/23.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Болею</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/24.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Сплю</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/25.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Плачу</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/26.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Звезда</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/27.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Падаю со смеху</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/28.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Слушаю музыку</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/29.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Тихо</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/30.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">В поиске</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/31.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Отлично</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/32.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Дразнюсь</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/33.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Боюсь</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/34.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">В ярости</span>
														</a>
													</li>
													<li class="b-moods-list_li">
														<a href="" class="b-moods-list_a">
															<img src="/images/widget/mood/35.png" class="b-moods-list_img" >
															<span class="b-moods-list_tx">Есть повод</span>
														</a>
													</li>
												</ul>
			           						 </div>
		           						 </div>
										<img src="/images/widget/mood/6.png">
									</div>
									<div class="b-user-mood_hold">
										<div class="b-user-mood_tx">- мое настроение</div>
										<a href="" class="a-pseudo font-small margin-l10">Изменить</a> &nbsp;
										<a href="" class="a-pseudo font-small color-gray">Удалить</a>
									</div>
								</div>
							</div>
						
							<div class=" clearfix">
								<a href="" class="btn-blue btn-h46 float-r btn-inactive">Добавить</a>
								<a href="" class="btn-gray-light btn-h46 float-r margin-r15">Отменить</a>
								
								<div class="float-l">
									<div class="privacy-select clearfix">
										<div class="privacy-select_hold clearfix">
											<div class="privacy-select_tx">Для кого:</div>
											<div class="privacy-select_drop-hold">
												<a href="" class="privacy-select_a">
													<span class="ico-users ico-users__friend active"></span>
													<span class="privacy-select_a-tx">только <br>друзьям</span>
												</a>
											</div>
											<div class="privacy-select_drop">
												<div class="privacy-select_i">
													<a href="" class="privacy-select_a">
													<span class="ico-users ico-users__all"></span>
													<span class="privacy-select_a-tx">для <br>всех</span>
													</a>
												</div>
												<div class="privacy-select_i">
													<a href="" class="privacy-select_a">
													<span class="ico-users ico-users__friend"></span>
													<span class="privacy-select_a-tx">только <br>друзьям</span>
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
	<!-- /popup-user-add-status -->
	
</div>
</body>
</html>