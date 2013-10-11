﻿<!DOCTYPE html>
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
				
				<div class="textalign-c margin-b40 clearfix">
					<a href="" class="btn-green btn-h46">Жираф рекомендует</a>
				</div>
				
				
				<div class="menu-list menu-list__purple">
					<a href="" class="menu-list_i active">
						<span class="menu-list_hold">
							<span class="menu-list_ico-img">
								<img src="/images/club/0-w50.png" alt="">
							</span>
							<span class="menu-list_tx">Все подписки</span>
							<span class="menu-list_count">+ 28</span>
						</span>
					</a>
					<a href="" class="menu-list_i">
						<span class="menu-list_hold">
							<span class="menu-list_tx">Новое у друзей</span>
							<span class="menu-list_count">+ 2568</span>
						</span>
					</a>
					<a href="" class="menu-list_i active">
						<span class="menu-list_hold">
							<span class="menu-list_tx">Новое в блогах</span>
							<span class="menu-list_count">+ 28</span>
						</span>
					</a>
					<a href="" class="menu-list_i">
						<span class="menu-list_hold">
							<span class="menu-list_ico-img">
								<img src="/images/club/10-w50.png" alt="">
							</span>
							<span class="menu-list_tx">Домашние хлопоты</span>
							<span class="menu-list_count">+ 2</span>
						</span>
					</a>
					<a href="" class="menu-list_i">
						<span class="menu-list_hold">
							<span class="menu-list_ico-img">
								<img src="/images/club/5-w50.png" alt="">
							</span>
							<span class="menu-list_tx">Наши питомцы</span>
							<span class="menu-list_count">+ 2</span>
						</span>
					</a>
				</div>
				
			</div>
			<div class="col-23-middle col-gray">

				<div class="b-article-conversion b-article-conversion__contest b-article-conversion__pets1 clearfix">
					<a href="" class="a-pseudo b-article-conversion_hide">Скрыть</a>
					<div class="b-article-conversion_tx-top">Внимание! С 11 октября стартовал <br>конкурс рассказов о вашем домашнем питомце!     </div>
					<div class="heading-title textalign-c clearfix"> <img src="/images/contest/club/pets1/small.png" alt=""> Наш домашний любимчик</div>
					<div class="textalign-c font-middle">
						<a href="">Участники конкурса (68)</a>
					</div>

					<div class="b-article b-article-prev clearfix">
						<div class="float-l">
							<div class="like-control like-control__smallest clearfix">
								<a href="" class="ava middle">
									<img alt="" src="http://img.happy-giraffe.ru/avatars/15292/ava/7f15174692ae858803ca7f2079f1bba0.jpg">
								</a>
								<a class="like-control_ico like-control_ico__like powertip" href="" title="Нравиться">0</a>
								<div class="position-r">
									<a class="like-control_ico like-control_ico__repost powertip" title="Репост" href="">0</a>
								</div>
								<div class="favorites-control">
									<a class="favorites-control_a powertip" href="" title="В избранное">789</a>
								</div>
							</div>
						</div>
						<div class="b-article-prev_cont clearfix">
							<div class="clearfix">
								<div class="meta-gray">
									<a class="meta-gray_comment" href="">
										<span class="ico-comment ico-comment__gray"></span>
										<span class="meta-gray_tx">35</span>
									</a>
									<div class="meta-gray_view">
										<span class="ico-view ico-view__gray"></span>
										<span class="meta-gray_tx">305</span>
									</div>
								</div>
								<div class="float-l">
									<div class="clearfix">
										<a class="b-article-prev_author" href="">Инна</a>
									</div>
									<span class="font-smallest color-gray">Сегодня 13:25</span>
								</div>
							</div>
							<div class="b-article-prev_t clearfix">
								<a class="b-article-prev_t-a" href="">Готовим список: что взять с собой на море с ребенком? </a>
							</div>
							<div class="b-article-prev_in">
								<div class="b-article_in-img">
									<iframe width="235" height="129" frameborder="0" allowfullscreen="" src="http://www.youtube.com/embed/pehSAUTqjRs?wmode=transparent"></iframe>
								</div>
							</div>
						</div>
					</div>
					
					<div class="b-article b-article-prev clearfix">
						<div class="float-l">
							<div class="like-control like-control__smallest clearfix">
								<a href="" class="ava middle">
									<span class="icon-status status-online"></span>
									<img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg">
								</a>
								<a class="like-control_ico like-control_ico__like powertip" href="" title="Нравиться">5</a>
								<div class="position-r">
									<a class="like-control_ico like-control_ico__repost powertip" title="Репост" href="">5</a>
								</div>
								<div class="favorites-control">
									<a class="favorites-control_a powertip" href="" title="В избранное">789</a>
								</div>
							</div>
						</div>
						<div class="b-article-prev_cont clearfix">
							<div class="clearfix">
								<div class="meta-gray">
									<a class="meta-gray_comment" href="">
										<span class="ico-comment ico-comment__gray"></span>
										<span class="meta-gray_tx">35</span>
									</a>
									<div class="meta-gray_view">
										<span class="ico-view ico-view__gray"></span>
										<span class="meta-gray_tx">305</span>
									</div>
								</div>
								<div class="float-l">
									<div class="clearfix">
										<a class="b-article-prev_author" href="">Галина</a>
									</div>
									<span class="font-smallest color-gray">Сегодня 13:25</span>
								</div>
							</div>
							<div class="b-article-prev_t clearfix">
								<a class="b-article-prev_t-a" href="">ГотовимсписокГотовимсписокГотовимсписок: </a>
							</div>
							<div class="b-article-prev_in">
								<div class="b-article_in-img">
									<!-- img width 235px -->
									<img alt="Ночные гости - кто они фото 1" class="content-img" src="http://img.happy-giraffe.ru/thumbs/700x700/56/edad8d334a0b4a086a50332a2d8fd0fe.JPG" title="Ночные гости - кто они фото 1">
								</div>
							</div>
						</div>
					</div>
					<div class="clearfix">
						<div class="b-article-conversion_tx-bottom">Расскажите о своих домашних питомцах!  </div>
						<div class="textalign-c margin-b20">
							<a href="" class="btn-green btn-h46">Принять участие!</a>
						</div>
					</div>
				</div>

				<div class="clearfix textalign-r margin-20">
					<span class="color-gray-dark padding-r5">Показывать только новые </span>
					<a class="a-checkbox active" href=""></a>
				</div>
				<div class="b-article clearfix">
					<div class="float-l">
						<div class="like-control like-control__small-indent clearfix">
							<a href="" class="ava male">
								<span class="icon-status status-online"></span>
								<img alt="" src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg">
							</a>
						</div>
						<div class="like-control clearfix">
							<a href="" class="like-control_ico like-control_ico__like">865</a>
							<a href="" class="like-control_ico like-control_ico__repost">5</a>
							<a href="" class="like-control_ico like-control_ico__favorites active">123865</a>
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
								<span class="font-smallest color-gray">Сегодня 13:25</span>
							</div>
						</div>
						<div class="b-article_t">
							<div class="b-article_t-new">новое</div>
							<a href="" class="b-article_t-a">Торт без выпечки «Апельсинка» </a>
						</div>

						<div class="article-contest article-contest__pets1">
							<div class="article-contest_col1">
								<img src="/images/contest/club/pets1/small.png" alt="">
								<div class="article-contest_name">Запись участвует в конкурсе <br>
									<a href="">Наш домашний любимец</a>
								</div>
							</div>
							<div class="article-contest_count">
								<div class="article-contest_count-num">453</div>
								<div class="article-contest_count-desc">балла</div>
							</div>
							<div class="article-contest_col3">
								<div class="textalign-c">
								<div class="margin-b5">Участники конкурса (56)</div>
								<a href="" class="ava female small">
									<span class="icon-status status-online"></span>
									<img alt="" src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG">
								</a>
								<a href="" class="ava female small">
									<span class="icon-status status-online"></span>
								</a>
								<a href="" class="ava female small">
									<span class="icon-status status-online"></span>
									<img alt="" src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG">
								</a>
								<a href="" class="ava female small">
									<span class="icon-status status-online"></span>
									<img alt="" src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG">
								</a>
								<a href="" class="ava female small">
									<span class="icon-status status-online"></span>
								</a>
								</div>
							</div>
						</div>

						<div class="b-article_in clearfix">
							<div class="wysiwyg-content clearfix">
								<p>	В половине чашке горячей воды разведем желатин. Дадим ему остыть. Желе для торта разводим согласно инструкции. Поломаем не небольшие кусочки крекер. Апельсин почистим и разберем на дольки. 5. Выложим... </p>
								<div class="b-article_in-img">
									<a href="">
										<img src="/images/example/w580-h385.jpg" alt="">
									</a>
								</div>
							</div>
						</div>
						<div class="textalign-r">
							<a class="b-article_more" href="">Смотреть далее</a>
						</div>
						
						<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/comments-gray-empty.php'; ?>
						
					</div>
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
							<div class="like-control like-control__pinned clearfix">
								<a href="" class="like-control_ico like-control_ico__like">865</a>
								<a href="" class="like-control_ico like-control_ico__repost">5</a>
								<a href="" class="like-control_ico like-control_ico__favorites active">123865</a>
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
								<span class="font-smallest color-gray">Сегодня 13:25</span>
							</div>
						</div>
						<h2 class="b-article_t">
							<div class="b-article_t-new">новое</div>
							<a href="" class="b-article_t-a">Самое лучшее утро - просыпаюсь, а ты рядом </a>
							
						</h2>
						<div class="b-article_in clearfix">
							<div class="wysiwyg-content clearfix">								
								<p>Практически нет девушки, которая не переживала бы за отношения героев "Сумерек" как в на экранах, так и в жизни. Но, к сожалению, даже несмотря на то, что недавно герои "Сумерек" радовали всех тем, что у них невероятный роман  и в рельной жизни, а не только лишь на экране, все же <a href="">Роберт Паттинсон</a>  и Кристен Стюарт расстались и пока решили взять паузу в своих отношениях.</p>
								
							</div>
							<div class="photo-grid clearfix">
						        <div class="photo-grid_row clearfix" >
						        	<!-- Ловить клик на photo-grid_i для показа увеличенного фото -->
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
					                <div class="photo-grid_i">
				                    	<img class="photo-grid_img" src="/images/example/photo-grid-3.jpg" alt="">
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
						</div>
						
						<div class="textalign-r">
							<a class="b-article_more" href="">Смотреть далее</a>
						</div>
						
						<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/comments-gray.php'; ?>
						
					</div>
				</div>

				<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/yiipagination.php'; ?>
			</div>
		</div>
		</div>
		
		<a href="#layout" id="btn-up-page"></a>
		<div class="footer-push"></div>
	</div>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/footer.php'; ?>
</div>

<div class="display-n">

</div>
</body>
</html>