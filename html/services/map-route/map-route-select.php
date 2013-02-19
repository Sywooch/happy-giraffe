<!DOCTYPE html>
<!--[if lt IE 8]>      <html class=" ie7"> <![endif]-->
<!--[if IE 8]>         <html class=" ie8"> <![endif]-->
<!--[if IE 9]>         <html class=" ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class=""> <!--<![endif]-->
<head>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/head.php'; ?>

</head>
<body class="body-club">

	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/top-line-menu.php'; ?>
	
<div class="layout-container">
	<div class="layout-wrapper">
		<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/header-new.php'; ?>
			
		<div id="content" class="layout-content clearfix">

			<div id="crumbs"><a href="">Главная</a> > <a href="">Сервисы</a> > <span>Маршруты</span></div>
			
			<div class="map-route-search">
				<a href="#" class="map-route-search_new a-pseudo">Новый маршрут</a>
				<h1 class="map-route-search_h1">Маршрут  Киев - Донецк </h1>
				<form action="" class="map-route-search_form clearfix">
					<input type="" class="map-route-search_itx itx-bluelight" placeholder="Откуда">
					<a href="" class="map-route-search_reverse"></a>
					<input type="" class="map-route-search_itx itx-bluelight" placeholder="Куда">
					<button class="btn-green map-route-search_btn">Проложить <br> маршрут</button>
				</form>
				<p>Узнайте, как доехать на авто от Киева до Донецка. <br>
				Схема трассы Донецк-Киев на карте. Выбирайте нужные вам дороги, трассы, шоссе и магистрали на пути от Донецка до Киева.</p>
				
			</div>
			<div class="margin-b30">
				<img src="/images/services/map-route/map.jpg" alt="">
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
					
					<div class="map-route-share">
						<div class="map-route-share_tx">Отправьте маршрут поездки Донецк-Киев своим друзьям</div>
						<div class="custom-likes-small">
							<a href="" class="custom-like-small">
								<span class="custom-like-small_icon odkl"></span>
							</a>
							<a href="" class="custom-like-small">
								<span class="custom-like-small_icon mailru"></span>
							</a>
						
							<a href="" class="custom-like-small">
								<span class="custom-like-small_icon vk"></span>
							</a>
						
							<a href="" class="custom-like-small">
								<span class="custom-like-small_icon fb"></span>
							</a>
							<a href="" class="custom-like-small" >
								<span class="custom-like-small_icon mail"></span>
							</a>
							<div class="custom-like-small-popup">
								<div class="custom-like-small-popup_t">Отправить маршрут другу</div>
								<input type="text" name="" id="" class="custom-like-small-popup_it itx-bluelight" placeholder="Свой email">
								<input type="text" name="" id="" class="custom-like-small-popup_it itx-bluelight" placeholder="Email друга">
								<div class="clearfix"><img src="/images/captcha.png"></div>
								<input type="text" name="" id="" class="custom-like-small-popup_it itx-bluelight" placeholder="Введите знаки с картинки">
								<button class="custom-like-small-popup_btn btn-green btn-medium">Отправить</button>
							</div>
						</div>
						<div class="map-route-share_tx">Ссылка на этот маршрут:</div>
						<div class="link-box">
							<a href="" class="link-box_a">http://www.happy-giraffe.ru/user/15128/blog/post28687</a>
						</div>
					</div>
					<div class="watchers">
						<div class="watchers_t">Маршрут <br>просмотрели</div>
						<div class="watchers_eye"></div>
						<div class="watchers_count">3 485</div>
					</div>
					
					
					
					<div class="map-route-share">
						<div class="map-route-share_tx">Отправьте маршрут поездки Донецк-Киев своим друзьям</div>
						<div class="custom-likes-small">
							<a href="" class="custom-like-small">
								<span class="custom-like-small_icon odkl"></span>
							</a>
							<a href="" class="custom-like-small">
								<span class="custom-like-small_icon mailru"></span>
							</a>
						
							<a href="" class="custom-like-small">
								<span class="custom-like-small_icon vk"></span>
							</a>
						
							<a href="" class="custom-like-small">
								<span class="custom-like-small_icon fb"></span>
							</a>
							<a href="" class="custom-like-small" >
								<span class="custom-like-small_icon mail"></span>
							</a>
							<div class="custom-like-small-popup" style="display:block;">
								<div class="custom-like-small-popup_t">Отправить маршрут другу</div>
								<input type="text" name="" id="" class="custom-like-small-popup_it itx-bluelight" placeholder="Email друга">
								<textarea name="" id="" cols="20" rows="3" class="custom-like-small-popup_textarea itx-bluelight" placeholder="Добавить сообщение"></textarea>
								<button class="custom-like-small-popup_btn btn-green btn-medium">Отправить</button>
							</div>
						</div>
						<div class="map-route-share_tx">Ссылка на этот маршрут:</div>
						<div class="link-box">
							<a href="" class="link-box_a">http://www.happy-giraffe.ru/user/15128/blog/post28687</a>
						</div>
					</div>
					
				</div>
				<div class="col-23">
					<h2>Пункты следования на пути Киев - Донецк</h2>
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
					
					
<div class="default-comments">

	<div class="comments-meta clearfix">
		<div class="clearfix">
			<div class="title">Комментарии</div>
			<div class="count">(55)</div>
		</div>	
		<p class="margin-5">Отзавы водителей о состоянии трассы Киев Донецк</p>
	</div>
	
	
	<div class="comment-add clearfix">
		<div class="comment-add_user">
			<a href="">Авторизируйтесь</a>
			<div class="social-small-row clearfix">
				<em>или войти с помощью</em> <br />
				<ul class="social-list-small">
					<li class="odnoklasniki"><a href="#"></a></li>
					<li class="mailru"><a href="#"></a></li>
					<li class="vkontakte"><a href="#"></a></li>
					<li class="facebook"><a href="#"></a></li>
				</ul>
			</div>
		</div>
		<div class="comment-add_form-holder">
			<input type="text" name="" class="input-text" placeholder="Введите ваш комментарий"/>
		</div>
	</div>
	
	<ul>
		<li>
			<div class="comment-in clearfix">
				<div class="header clearfix">
					<div class="user-info clearfix">
						<div class="ava female"></div>
						<div class="details">
							<span class="icon-status status-online"></span>
							<a href="" class="username">Дарья</a>
							<div class="user-fast-buttons clearfix">
								<a href="" class="add-friend"><span class="tip">Пригласить в друзья</span></a>
								<a href="" class="new-message"><span class="tip">Написать сообщение</span></a>
							</div>
							
						</div>
					</div>
				</div>
				<div class="content">
					<div class="meta">
						<span class="num">2</span>
						<span class="date">Сегодня, 20:45</span>
					</div>
					<div class="content-in">
						<p>Коляска просто супер!!! Очень удобная и функциональная. Ни разу не пожалели, что купили именно эту коляску. Это маленький вездеход :)</p>
					</div>
					<div class="actions">
						<a href="" class="claim">Нарушение!</a>
						<div class="admin-actions">
							<a href="" class="edit"><i class="icon"></i></a>
							<a href="#deleteComment" class="remove fancy"><i class="icon"></i></a>
						</div>
						<a href="">Ответить</a>
						&nbsp;
						<a href="" class="quote-link">С цитатой</a>
					</div>
				</div>
			</div>
		</li>
	</ul>
	
</div>
	
				</div>
			</div>
			
			
		</div>	
		
		<div class="footer-push"></div>
		
	</div>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/footer.php'; ?>
</div>
</body>
</html>
