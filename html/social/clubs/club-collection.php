<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="ie7"> <![endif]-->
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class=""> <!--<![endif]-->
<head>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/head.php'; ?>
	
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
				<div class="user-add-record user-add-record__small clearfix">
					<div class="user-add-record_ava-hold">
						<a href="" class="ava male middle">
							<span class="icon-status status-online"></span>
							<img alt="" src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg">
						</a>
					</div>
					<div class="user-add-record_hold">
						<div class="user-add-record_tx">Я хочу добавить</div>
						<a href="#popup-user-add-article"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__article fancy powertip" title="Статью"></a>
						<a href="#popup-user-add-photo"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__photo fancy powertip" title="Фото"></a>
						<a href="#popup-user-add-video"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__video fancy active powertip" title="Видео"></a>
						<a href="#popup-user-add-status"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__status fancy powertip" title="Статус"></a>
					</div>
				</div>
				<div class="padding-l20">
					<div class="crumbs-small clearfix">
						<ul class="crumbs-small_ul">  
							<li class="crumbs-small_li">Я здесь:</li>
							<li class="crumbs-small_li"><a href="" class="crumbs-small_a">Главная</a></li> &gt;
							<li class="crumbs-small_li"><a href="" class="crumbs-small_a">Наш дом</a></li> &gt;
							<li class="crumbs-small_li"><a href="" class="crumbs-small_a">Цветы в доме</a></li> &gt;
							<li class="crumbs-small_li"><span class="crumbs-small_last">Форум</span></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		
		<div class="b-section b-section__collection">
			<div class="b-section_hold">
				<div class="b-section_collection">
					<img src="/images/club/collection/1.png" alt="" class="b-section_collection-img">
					<div class="b-section_collection-t">Беременность и дети</div>
				</div>
			</div>
		</div>
		
		<div class="content-cols clearfix">
			<div class="col-1">
			
				<div class="club-list margin-t20 clearfix">
					<div class="clearfix textalign-c">
						<span class="heading-medium">Выбери свой клуб </span>
					</div>
					<ul class="club-list_ul clearfix">
						<li class="club-list_li">
							<a href="" class="club-list_i">
								<span class="club-list_img-hold">
									<img src="/images/club/1.png" alt="" class="club-list_img">
								</span>
								<span class="club-list_i-name">Украшаем дом</span>
							</a>
							<a href="" class="club-list_check powertip" title="Вступить в клуб"></a>
						</li>
						<li class="club-list_li club-list_li__in">
							<a href="" class="club-list_i">
								<span class="club-list_img-hold">
									<img src="/images/club/2.png" alt="" class="club-list_img">
								</span>
								<span class="club-list_i-name">Дети</span>
							</a>
							<a href="" class="club-list_check powertip" title="Покинуть клуб"></a>
						</li>
						<li class="club-list_li">
							<a href="" class="club-list_i">
								<span class="club-list_img-hold">
									<img src="/images/club/3.png" alt="" class="club-list_img">
								</span>
								<span class="club-list_i-name">Цветы в доме</span>
							</a>
							<a href="" class="club-list_check powertip" title="Вступить в клуб"></a>
						</li>
						<li class="club-list_li">
							<a href="" class="club-list_i">
								<span class="club-list_img-hold">
									<img src="/images/club/4.png" alt="" class="club-list_img">
								</span>
								<span class="club-list_i-name">Свадьба</span>
							</a>
							<a href="" class="club-list_check powertip" title="Вступить в клуб"></a>
						</li>
						<li class="club-list_li">
							<a href="" class="club-list_i">
								<span class="club-list_img-hold">
									<img src="/images/club/5.png" alt="" class="club-list_img">
								</span>
								<span class="club-list_i-name">Наши питомцы</span>
							</a>
							<a href="" class="club-list_check powertip" title="Вступить в клуб"></a>
						</li>
						<li class="club-list_li">
							<a href="" class="club-list_i">
								<span class="club-list_img-hold">
									<img src="/images/club/6.png" alt="" class="club-list_img">
								</span>
								<span class="club-list_i-name">Образование</span>
							</a>
							<a href="" class="club-list_check powertip" title="Вступить в клуб"></a>
						</li>
						<li class="club-list_li">
							<a href="" class="club-list_i">
								<span class="club-list_img-hold">
									<img src="/images/club/7.png" alt="" class="club-list_img">
								</span>
								<span class="club-list_i-name">Выходные с семьей</span>
							</a>
							<a href="" class="club-list_check powertip" title="Вступить в клуб"></a>
						</li>
						<li class="club-list_li">
							<a href="" class="club-list_i">
								<span class="club-list_img-hold">
									<img src="/images/club/8.png" alt="" class="club-list_img">
								</span>
								<span class="club-list_i-name">Красота и мода</span>
							</a>
							<a href="" class="club-list_check powertip" title="Вступить в клуб"></a>
						</li>
					</ul>
				</div>
							
				<div class="club-services club-services__sidebar">
					<div class="clearfix textalign-c">
						<span class="heading-medium">Популярные сервисы </span>
					</div>
					<div class="club-services_heading-sub textalign-c">для мастеров</div>
					<div class="club-services_i clearfix">
						<div class="club-services_img">
							<img src="/images/services/service_img_13.png">
						</div>
						<div class="club-services_desc">
							<a href="" class="club-services_t">Счетчик калорий</a>
						</div>
					</div>
					<div class="club-services_i clearfix">
						<div class="club-services_img">
							<img src="/images/services/service_img_12.png">
						</div>
						<div class="club-services_desc">
							<a href="" class="club-services_t">Калькулятор мер</a>
						</div>
					</div>
				</div>
				
			</div>
			<div class="col-23-middle ">
				<div class="col-gray">
					<div class="heading-medium margin-20">Прямой эфир</div>
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
							<h2 class="b-article_t">
								<div class="b-article_t-new">новое</div>
								<a href="" class="b-article_t-a">Торт без выпечки «Апельсинка» </a>
							</h2>
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