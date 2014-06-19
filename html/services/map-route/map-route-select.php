<!DOCTYPE html>
<!--[if lt IE 8]>      <html class=" ie7"> <![endif]-->
<!--[if IE 8]>         <html class=" ie8"> <![endif]-->
<!--[if IE 9]>         <html class=" ie9"> <![endif]-->
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
								<li class="crumbs-small_li"><a href="" class="crumbs-small_a">Интересы и увлечения</a></li> &gt;
								<li class="crumbs-small_li"><a href="" class="crumbs-small_a">Наш автомобиль</a></li> &gt;
								<li class="crumbs-small_li"><span class="crumbs-small_last">Маршруты</span></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			
			<div class="b-section">
				<div class="b-section_hold">
					<div class="content-cols clearfix">
						<div class="col-1">
							<div class="club-list club-list__big clearfix">
								<ul class="club-list_ul textalign-c clearfix">
									<li class="club-list_li">
										<a href="" class="club-list_i">
											<span class="club-list_img-hold">
												<img src="/images/club/27-w130.png" alt="" class="club-list_img">
											</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-23-middle">
							<div class="padding-l20">
								<div class="b-section_t"><a href="">Наш автомобиль</a></div>
								<div class="clearfix">
									<ul class="b-section_ul clearfix">
										<li class="b-section_li"><a href="" class="b-section_li-a">Форум</a></li>
										<li class="b-section_li"><span class="b-section_li-a active">Маршруты</span></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="content-cols margin-l-20 clearfix">
				<div class="col-white padding-20 clearfix">
					<div id="crumbs"><a href="">Главная</a> > <a href="">Сервисы</a> > <span>Маршруты</span></div>
					
					<div class="map-route-search">
						<a href="#" class="map-route-search_new a-pseudo">Новый маршрут</a>
						<h1 class="map-route-search_h1">Маршрут  Киев - Донецк </h1>
						<form action="" class="map-route-search_form clearfix">
							<input type="" class="map-route-search_itx itx-bluelight" placeholder="Откуда">
							<a href="" class="map-route-search_reverse"></a>
							<input type="" class="map-route-search_itx itx-bluelight" placeholder="Куда">
							<button class="btn-gray map-route-search_btn">Проложить <br> маршрут</button>
						</form>
						<p>Узнайте, как доехать на авто от Киева до Донецка. <br>
						Схема трассы Донецк-Киев на карте. Выбирайте нужные вам дороги, трассы, шоссе и магистрали на пути от Донецка до Киева.</p>
						
					</div>
					<div class="margin-b30 map-canvas">
						<img src="/images/services/map-route/map.jpg" alt="">
						<div class="map-canvas_overlay">
							Подождите. Мы формируем для вас маршрут.
							<div id="infscr-loading"><img src="/images/ico/ajax-loader.gif" alt="Loading..."><div>Загрузка</div></div>
						</div>
					</div>
					<div class="margin-b30 map-canvas">
						<img src="/images/services/map-route/map.jpg" alt="">
						<div class="map-canvas_overlay map-canvas_overlay__error">
							Извините. Этот маршрут проложить невозможно.
						</div>
					</div>
					
					<div class="content-cols clearfix">
						<div class="col-1">
							<div class="map-route-calc">
								<div class="map-route-calc_item">
									<div class="clearfix">
										<div class="map-route-calc_img">
											<img src="/images/services/map-route/map-route-car.png" alt="">
										</div>
										<div class="map-route-calc_t clearfix">Расстояние между Киевом и Донецком</div>
									</div>
									<div class="map-route-calc_value">1 388 <span class="map-route-calc_units">км</span></div>
									<div class="map-route-calc_desc">Столько километров от Киева до Донецка на автомобиле</div>
								</div>
								
								<div class="map-route-calc_item">
									<div class="clearfix">
										<div class="map-route-calc_img">
											<img src="/images/services/map-route/map-route-time.png" alt="">
										</div>
										<div class="map-route-calc_t clearfix">Время в пути <br>от Киева до Донецка</div>
									</div>
									<div class="map-route-calc_row clearfix">
										<input type="text" name="" id="" class="map-route-calc_itx map-route-calc_itx__speed itx-bluelight" value="80">
										<label for="" class="map-route-calc_label">Ср. скорость <br> км / ч</label>
									</div>
									<div class="map-route-calc_value">
										14 <span class="map-route-calc_units">ч</span>
										8  <span class="map-route-calc_units">м</span>
									</div>
									<div class="map-route-calc_desc">Столько времени ехать от Киева до Донецка</div>
								</div>
								
								<div class="map-route-calc_item">
									<div class="clearfix">
										<div class="map-route-calc_img">
											<img src="/images/services/map-route/map-route-fuel-cost.png" alt="">
										</div>
										<div class="map-route-calc_t clearfix">Расход и стоимость топлива</div>
									</div>
									<div class="map-route-calc_row clearfix">
										<input type="text" name="" id="" class="map-route-calc_itx map-route-calc_itx__fuel itx-bluelight" value="80">
										<label for="" class="map-route-calc_label">л. / 100 км</label>
									</div>
									<div class="map-route-calc_row clearfix">
										<input type="text" name="" id="" class="map-route-calc_itx map-route-calc_itx__cost itx-bluelight" value="180">
										<label for="" class="map-route-calc_label">
											<div class="chzn-v2">
												<select name="" id="" class="chzn w-85">
													<option value="">руб / л.</option>
													<option value="">руб / гал.</option>
													<option value="">руб / бар.</option>
												</select>
											</div>
										</label>
									</div>
									<div class="map-route-calc_value">
										142 <span class="map-route-calc_units">л</span>
									</div>
									<div class="map-route-calc_value">
										3 142 <span class="map-route-calc_units">руб.</span>
									</div>
								</div>
							</div>
							
							<div class="watchers">
								<div class="watchers_t">Маршрут <br>просмотрели</div>
								<div class="watchers_eye"></div>
								<div class="watchers_count">3 485</div>
							</div>
							
							<div class="map-route-share">
								<div class="map-route-share_tx">Отправьте маршрут поездки Донецк-Киев своим друзьям</div>
								<div class="custom-likes-b textalign-l margin-b20">
									
									<a href="" class="custom-like">
										<span class="custom-like_icon odnoklassniki"></span>
									</a>
									<a href="" class="custom-like">
										<span class="custom-like_icon vkontakte"></span>
									</a>
								
									<a href="" class="custom-like">
										<span class="custom-like_icon facebook"></span>
									</a>
								
									<a href="" class="custom-like">
										<span class="custom-like_icon twitter"></span>
									</a>
									<div class="display-ib position-rel">
										<a href="" class="custom-like">
											<span class="custom-like_icon mail"></span>
										</a>
										<!-- Место для попапа -->
									</div>
								</div>
								<div class="map-route-share_tx">Ссылка на этот маршрут:</div>
								<div class="link-box">
									<a href="" class="link-box_a">http://www.happy-giraffe.ru/user/15128/blog/post28687</a>
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
							
							<div class="map-route-share">
								<div class="map-route-share_tx">Отправьте маршрут поездки Донецк-Киев своим друзьям</div>
								<div class="custom-likes-b textalign-l">
									<a href="" class="custom-like">
										<span class="custom-like_icon odnoklassniki"></span>
									</a>
									<a href="" class="custom-like">
										<span class="custom-like_icon vkontakte"></span>
									</a>
								
									<a href="" class="custom-like">
										<span class="custom-like_icon facebook"></span>
									</a>
								
									<a href="" class="custom-like">
										<span class="custom-like_icon twitter"></span>
									</a>
									<div class="display-ib position-rel">
										<a href="" class="custom-like">
											<span class="custom-like_icon mail"></span>
										</a>
										
										<div class="custom-likes-b-popup" style="display:block;">
											<div class="custom-likes-b-popup_t">Отправить маршрут другу</div>
											<div class="clearfix margin-b10">
												<input type="text" name="" id="" class="custom-likes-b-popup_itx itx-gray" placeholder="Свой Email">
												<div class="errorMessage" >Введите правильный E-mail</div>
											</div>
											<div class="clearfix margin-b10">
												<input type="text" name="" id="" class="custom-likes-b-popup_itx itx-gray" placeholder="Email друга">
											</div>
											<div class="clearfix margin-b10">
												<textarea name="" id="" cols="20" rows="3" class="custom-likes-b-popup_textarea itx-gray" placeholder="Добавить сообщение"></textarea>
											</div>
											<div class="clearfix textalign-r">
												<button class="custom-like-small-popup_btn btn-gray-light margin-r5">Отменить</button>
												<button class="custom-like-small-popup_btn btn-green">Отправить</button>
											</div>
											
											<div class="custom-likes-b-popup_win display-n">
												<div class="custom-likes-b-popup_win-tx">
												Письмо отправлено
												</div>
											</div>
										</div>
									</div>
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
							
							<div class="map-route-share">
								<div class="map-route-share_tx">Отправьте маршрут поездки Донецк-Киев своим друзьям</div>
								<div class="custom-likes-b textalign-l">
									<a href="" class="custom-like">
										<span class="custom-like_icon odnoklassniki"></span>
									</a>
									<a href="" class="custom-like">
										<span class="custom-like_icon vkontakte"></span>
									</a>
								
									<a href="" class="custom-like">
										<span class="custom-like_icon facebook"></span>
									</a>
								
									<a href="" class="custom-like">
										<span class="custom-like_icon twitter"></span>
									</a>
									<div class="display-ib position-rel">
										<a href="" class="custom-like">
											<span class="custom-like_icon mail"></span>
										</a>
										
										<div class="custom-likes-b-popup" style="display:block;">
											<div class="custom-likes-b-popup_t">Отправить маршрут другу</div>
											<div class="clearfix margin-b10">
												<input type="text" name="" id="" class="custom-likes-b-popup_itx itx-gray" placeholder="Свой Email">
												<div class="errorMessage" >Введите правильный E-mail</div>
											</div>
											<div class="clearfix margin-b10">
												<input type="text" name="" id="" class="custom-likes-b-popup_itx itx-gray" placeholder="Email друга">
											</div>
											<div class="clearfix margin-b10">
												<textarea name="" id="" cols="20" rows="3" class="custom-likes-b-popup_textarea itx-gray" placeholder="Добавить сообщение"></textarea>
											</div>
											<div class="clearfix textalign-r">
												<button class="custom-like-small-popup_btn btn-gray-light margin-r5">Отменить</button>
												<button class="custom-like-small-popup_btn btn-green">Отправить</button>
											</div>
											<div class="custom-likes-b-popup_win ">
												<div class="custom-likes-b-popup_win-tx">
												Письмо отправлено
												</div>
											</div>
										</div>
									</div>
								</div>
								
							</div>
							
						</div>
						<div class="col-23">
							<h2 class="margin-t15">Пункты следования на пути Киев - Донецк</h2>
							<table class="map-route-table">
								<col class="map-route-table_col1">
								<col class="map-route-table_col2">
								<col class="map-route-table_col3">
								<thead class="map-route-table_thead">
									<tr>
										<td class="map-route-table_thead-td"></td>
										<td class="map-route-table_thead-td">Пункт / регион</td>
										<td class="map-route-table_thead-td">Трасса</td>
										<td class="map-route-table_thead-td">Время участка </td>
										<td class="map-route-table_thead-td">Время в пути</td>
										<td class="map-route-table_thead-td">Участок, км     </td>
										<td class="map-route-table_thead-td">Всего, км</td>
									</tr>
								</thead>
								<tr class="map-route-table_tr">
									<td class="map-route-table_td">
										<div class="map-route-table_hold">
											<div class="map-route-start">A</div>
										</div>
									</td>
									<td class="map-route-table_td textalign-l">
										<div class="map-route-table_hold">
											<strong>Киев</strong> <br>
											Вологодская обл. Волог
										</div>
									</td>
									<td class="map-route-table_td">
										<div class="map-route-table_hold">
											<strong>M8</strong>
										</div>
									</td>
									<td class="map-route-table_td">
										<div class="map-route-table_hold">
											0:00
										</div>
									</td>
									<td class="map-route-table_td">
										<div class="map-route-table_hold">
											1:00
										</div>
									</td>
									<td class="map-route-table_td">
										<div class="map-route-table_hold">
											0:00
										</div>
									</td>
									<td class="map-route-table_td">
										<div class="map-route-table_hold">
											1:00
										</div>
									</td>
								</tr>
								<tr class="map-route-table_tr">
									<td class="map-route-table_td">
										<div class="map-route-table_hold">
											<div class="map-route-point">1</div>
										</div>
									</td>
									<td class="map-route-table_td textalign-l">
										<div class="map-route-table_hold">
											<strong>Киев</strong> <br>
											Вологодская обл.
										</div>
									</td>
									<td class="map-route-table_td">
										<div class="map-route-table_hold">
											<strong>M8</strong>
										</div>
									</td>
									<td class="map-route-table_td">
										<div class="map-route-table_hold">
											0:00
										</div>
									</td>
									<td class="map-route-table_td">
										<div class="map-route-table_hold">
											1:00
										</div>
									</td>
									<td class="map-route-table_td">
										<div class="map-route-table_hold">
											0:00
										</div>
									</td>
									<td class="map-route-table_td">
										<div class="map-route-table_hold">
											1:00
										</div>
									</td>
								</tr>
								<tr class="map-route-table_tr">
									<td class="map-route-table_td">
										<div class="map-route-table_hold">
											<div class="map-route-point">99</div>
										</div>
									</td>
									<td class="map-route-table_td textalign-l">
										<div class="map-route-table_hold">
											<strong>Киев</strong> <br>
											Вологодская обл.
										</div>
									</td>
									<td class="map-route-table_td">
										<div class="map-route-table_hold">
											<strong>M8</strong>
										</div>
									</td>
									<td class="map-route-table_td">
										<div class="map-route-table_hold">
											0:00
										</div>
									</td>
									<td class="map-route-table_td">
										<div class="map-route-table_hold">
											1:00
										</div>
									</td>
									<td class="map-route-table_td">
										<div class="map-route-table_hold">
											0:00
										</div>
									</td>
									<td class="map-route-table_td">
										<div class="map-route-table_hold">
											1:00
										</div>
									</td>
								</tr>
								<tr class="map-route-table_tr">
									<td class="map-route-table_td">
										<div class="map-route-table_hold">
											<div class="map-route-start"></div>
										</div>
									</td>
									<td class="map-route-table_td textalign-l">
										<div class="map-route-table_hold">
											<strong>Киев</strong> <br>
											Вологодская обл.
										</div>
									</td>
									<td class="map-route-table_td">
										<div class="map-route-table_hold">
											<strong>M8</strong>
										</div>
									</td>
									<td class="map-route-table_td">
										<div class="map-route-table_hold">
											0:00
										</div>
									</td>
									<td class="map-route-table_td">
										<div class="map-route-table_hold">
											1:00
										</div>
									</td>
									<td class="map-route-table_td">
										<div class="map-route-table_hold">
											0:00
										</div>
									</td>
									<td class="map-route-table_td">
										<div class="map-route-table_hold">
											1:00
										</div>
									</td>
								</tr>
							</table>
							
							<div class="map-route-other">
								<h3 class="map-route-other_title">С этим маршрутом искали</h3>
								<div class="clearfix">
									<ul class="map-route-other_ul clearfix">
										<li class="map-route-other_li">
											<a href="">Маршрут  Киев - Москва</a>
										</li>
										<li class="map-route-other_li">
											<a href="">Маршрут  Киев - Москва</a>
										</li>
										<li class="map-route-other_li">
											<a href="">Маршрут  Киев - Москва</a>
										</li>
										<li class="map-route-other_li">
											<a href="">Маршрут  Киев - Санкт-Петербург Петербург Петербург Санкт-Петербург Санкт-Петербург Санкт-Петербург- Санкт-Петербург</a>
										</li>
										<li class="map-route-other_li">
											<a href="">Маршрут  Киев - Москва</a>
										</li>
									</ul>
									
									<ul class="map-route-other_ul clearfix">
										<li class="map-route-other_li">
											<a href="">Маршрут  Киев - Санкт-Петербург</a>
										</li>
										<li class="map-route-other_li">
											<a href="">Маршрут  Киев - Москва - Киев - Санкт-Петербург  Киев - Санкт-Петербург</a>
										</li>
										</li>
										<li class="map-route-other_li">
											<a href="">Маршрут  Киев - Москва</a>
										</li>
										<li class="map-route-other_li">
											<a href="">Маршрут  Киев - Санкт-Петербург</a>
										</li>
										<li class="map-route-other_li">
											<a href="">Маршрут  Киев - Москва</a>
										</li>
									</ul>
								</div>
							</div>

							<div class="ban-route-danger">
								<a href="" class="ban-route-danger_a">
									<div class="ban-route-danger_ava">
										<span href="" class="ava ava__small ava__female"><img alt="" src="http://img.happy-giraffe.cdnvideo.ru/thumbs/72x72/220231/avabdc8f4a293ba7a8614e61a14082f0993.jpg" class="ava_img"></span>
										<span class="ban-route-danger_ava-name">Марина Шевкопляс</span>
									</div>
									<div class="ban-route-danger_t">20 самых опасных маршрутов в мире</div>
									<div class="textalign-r">
										<div class="btn-green-simple">Смотреть</div>
										
									</div>
								</a>
							</div>


								<div class="comments-gray comments-gray__map-route">
									<div class="comments-gray_t">
										<span class="comments-gray_t-a-tx">Все комментарии (28)</span>
										<a class="btn-green" href="">Добавить</a>
										<div class="color-gray fontstyle-i margin-b5 margin-t10">Отзавы водителей о состоянии трассы Киев Донецк</div>
									</div>
									<div class="comments-gray_hold">
										<div class="comments-gray_i comments-gray_i__self">
											<div class="comments-gray_ava">
												<a class="ava small male" href=""></a>
											</div>
											<div class="comments-gray_frame">
												<div class="comments-gray_header clearfix">
													<a class="comments-gray_author" href="">Ангелина Богоявленская </a>
													<span class="font-smallest color-gray">Сегодня 13:25</span>
												</div>
												<div class="comments-gray_cont wysiwyg-content">
													<p>	Мне безумно жалко всех женщин, но особенно Тину Кароль, я просто представить себе не могу <a href="">как она все это переживет</a> как она все это переживет(</p>
													<p>я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически производит поиск по сайту и подцепляет естественно студийные версии песен вместо нужных.  я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически </p>
												</div>
											</div>
											<div class="comments-gray_control comments-gray_control__self">
												<div class="comments-gray_control-hold">
													<div class="clearfix">
														<a class="message-ico message-ico__edit powertip" href=""></a>
													</div>
													<div class="clearfix">
														<a class="message-ico message-ico__del powertip" href=""></a>
													</div>
												</div>
											</div>
										</div>
										<div class="comments-gray_i">
											<a class="comments-gray_like like-hg-small powertip" href="">78</a>
											<div class="comments-gray_ava">
												<a class="ava small female" href=""></a>
											</div>
											<div class="comments-gray_frame">
												<div class="comments-gray_header clearfix">
													<a class="comments-gray_author" href="">Анг Богоявлен </a>
													<span class="font-smallest color-gray">Сегодня 14:25</span>
												</div>
												<div class="comments-gray_cont wysiwyg-content">
													<p>я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически производит поиск по сайту и подцепляет естественно студийные версии песен вместо нужных.  я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически </p>
												</div>
											</div>
											
											<div class="comments-gray_control">
												<div class="comments-gray_control-hold">
													<div class="clearfix">
														<a class="comments-gray_quote-ico powertip" href=""></a>
													</div>
													<div class="clearfix">
														<a class="message-ico message-ico__del powertip" href=""></a>
													</div>
												</div>
												<div class="clearfix">
													<a class="message-ico message-ico__warning powertip" href=""></a>
												</div>
											</div>
										</div>
										<div class="comments-gray_i">
											<a class="comments-gray_like like-hg-small powertip" href="">7918</a>
											<div class="comments-gray_ava">
												<a class="ava small female" href=""></a>
											</div>
											<div class="comments-gray_frame">
												<div class="comments-gray_header clearfix">
													<a class="comments-gray_author" href="">Анг Богоявлен </a>
													<span class="font-smallest color-gray">Сегодня 14:25</span>
												</div>
												<div class="comments-gray_cont wysiwyg-content">
													<p>я не нашел, где можно поменять название трека. </p>
												</div>
											</div>
											
											<div class="comments-gray_control">
												<div class="comments-gray_control-hold">
													<div class="clearfix">
														<a class="comments-gray_quote-ico powertip" href=""></a>
													</div>
													<div class="clearfix">
														<a class="message-ico message-ico__del powertip" href=""></a>
													</div>
												</div>
												<div class="clearfix">
													<a class="message-ico message-ico__warning powertip" href=""></a>
												</div>
											</div>
										</div>
										
										<div class="comments-gray_i comments-gray_i__recovery">
											<div class="comments-gray_ava">
												<a class="ava small female" href=""></a>
											</div>
											<div class="comments-gray_frame">
												<div class="comments-gray_header clearfix">
													<a class="comments-gray_author" href="">Анг Богоявлен </a>
													<span class="font-smallest color-gray">Сегодня 14:25</span>
												</div>
												<div class="comments-gray_cont wysiwyg-content">
													<p>Комментарий успешно удален. <a class="comments-gray_a-recovery" href=""> Восстановить?</a> </p>
												</div>
											</div>
										</div>
										
										<div class="comments-gray_i">
											<a class="comments-gray_like like-hg-small powertip" href="">78</a>
											<div class="comments-gray_ava">
												<a class="ava small female" href=""></a>
											</div>
											<div class="comments-gray_frame">
												<div class="comments-gray_header clearfix">
													<a class="comments-gray_author" href="">Анг Богоявлен </a>
													<span class="font-smallest color-gray">Сегодня 14:25</span>
												</div>
												<div class="comments-gray_cont wysiwyg-content">
													<p>я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически производит поиск по сайту </p>
													<p>
														<a class="comments-gray_cont-img-w" href="">
															<!--    max-width: 170px;  max-height: 110px; -->
															<img alt="" src="/images/example/w170-h110.jpg">
														</a>
														<a class="comments-gray_cont-img-w" href="">
															<img alt="" src="/images/example/w220-h309-1.jpg">
														</a>
														<a class="comments-gray_cont-img-w" href="">
															<img alt="" src="/images/example/w200-h133-1.jpg">
														</a>
													</p>
													<p>и подцепляет естественно студийные версии песен вместо нужных.  я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически </p>
												</div>
											</div>
											
											<div class="comments-gray_control">
												<div class="comments-gray_control-hold">
													<div class="clearfix">
														<a class="comments-gray_quote-ico powertip" href=""></a>
													</div>
												</div>
												<div class="clearfix">
													<a class="message-ico message-ico__warning powertip" href=""></a>
												</div>
											</div>
										</div>
									</div>
									<div class="comments-gray_add clearfix">
										
										<div class="comments-gray_ava">
											<a class="ava small female" href=""></a>
										</div>
										<div class="comments-gray_frame">
											<input type="text" placeholder="Ваш комментарий" class="comments-gray_add-itx itx-gray" id="" name="">
										</div>
									</div>
								</div>
			
						</div>
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
