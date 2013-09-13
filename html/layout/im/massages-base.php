<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="ie7"> <![endif]-->
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class=""> <!--<![endif]-->
<head>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/head.php'; ?>
	<script type="text/javascript" src="/javascripts/im.js"></script>

</head>
<body class="body-gray">

	
<div class="layout-container">
	<div class="layout-wrapper">
	
		<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/header-new.php'; ?>
		
		<div class="layout-content margin-b0">

		<div class="im">
		<div class="im_hold clearfix">
			<div class="im-sidebar">
				<h2 class="im-sidebar_t">Мои диалоги</h2>
				<div class="im-sidebar_search clearfix">
					<input type="text" name="" id="" class="im-sidebar_search-itx" placeholder="Найти по имени">
					<button class="im-sidebar_search-btn"></button>
				</div>
				<div class="im-user-list">
					<div class="im-user-list_i clearfix">
						<div class="im-user-settings">
							<a class="ava small female" href="">
								<span class="icon-status status-online"></span>
								<img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg">
							</a>
							<div class="im-user-settings_user">
								<a href="" class="">Арина Поплавская</a>
							</div>
						</div>
						<div class="im_watch powertip" title="Скрыть диалог"></div>
						<div class="im_count powertip" title="Отметить как прочитанное">2</div>
					</div>
					
					<div class="im-user-list_i active clearfix">
						<div class="im-user-settings">
							<a class="ava small female" href="">
								<span class="icon-status status-online"></span>
								<img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg">
							</a>
							<div class="im-user-settings_user">
								<a href="" class="">Архистратиг Богоявленгоявленский</a>
							</div>
						</div>
						<div class="im_watch powertip" title="Скрыть диалог"></div>
						<div class="im_count powertip" title="Отметить как прочитанное">4562</div>
					</div>
					
					<div class="im-user-list_i clearfix">
						<div class="im-user-settings">
							<a class="ava small female" href="">
								<span class="icon-status status-online"></span>
								<img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg">
							</a>
							<div class="im-user-settings_user">
								<a href="" class="">Арина Поплавская</a>
							</div>
						</div>
						
						<div class="im_watch powertip" title="Скрыть диалог"></div>
						<div class="im_count im_count__read powertip" title="Отметить как не прочитанное">44784</div>
					</div>
					<a href="" class="im-user-list_hide-a" onclick="im.hideContacts();return false;">Показать скрытые</a>
					<div class="im-user-list_hide-b">
						
						<div class="im-user-list_i clearfix">
							<div class="im-user-settings">
								<a class="ava small female" href="">
									<img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg">
								</a>
								<div class="im-user-settings_user">
									<a href="" class="">Арина Поплавская</a>
								</div>
							</div>
							
							<div class="im_watch powertip" title="Показать диалог"></div>
							<div class="im_count powertip" title="Отметить как прочитанное">236</div>
						</div>
						
					</div>
				</div>
			</div>
			<div class="im-center">
			
				<div class="im-center_top">
					<div class="im-tabs">
						<a href="" class="im_sound active powertip" title="Включить звуковые <br>оповещения"></a>
						<div class="im-tabs_i active"><a href="" class="im-tabs_a">Все</a></div>
						<div class="im-tabs_i"><a href="" class="im-tabs_a">Новые <span class="im_count">2</span> </a></div>
						<div class="im-tabs_i"><a href="" class="im-tabs_a">Кто в онлайн (12)</a></div>
						<div class="im-tabs_i"><a href="" class="im-tabs_a inactive">Друзья на сайте (0)</a></div>
					</div>
					<div class="im-panel">
						<div class="im-panel-icons">
							<div class="im-panel-icons_i">
								
								<a href="" class="im-panel-icons_i-a powertip" title="Добавить в друзья">
									<span class="im-panel-ico im-panel-ico__add-friend"></span>
									<span class="im-panel-icons_desc">Добавить <br>в друзья </span>
								</a>
								<!-- Запрос на добавление в друзья отправлен
								<span class="im-panel-icons_i-a powertip im-panel-icons_i-a__request" title="Добавить в друзья">
									<span class="im-panel-ico im-panel-ico__added-friend"></span>
									<span class="im-panel-icons_desc">Запрос <br> отправлен</span>
								</span> -->
								<!-- Друг
								<span class="im-panel-icons_i-a powertip im-panel-icons_i-a__friend" title="Друг">
									<span class="im-panel-ico im-panel-ico__added-friend"></span>
									<span class="im-panel-icons_desc">Друг</span>
								</span> -->
							</div>
							<div class="im-panel-icons_i">
								<a href="" class="im-panel-icons_i-a powertip" title="Заблокировать пользователя">
									<span class="im-panel-ico im-panel-ico__blacklist"></span>
									<span class="im-panel-icons_desc">В черный <br> список</span>
								</a>
								<div class="im-tooltip-popup">
									<div class="im-tooltip-popup_t">Вы уверены?</div>
									<p class="im-tooltip-popup_tx">Пользователь из черного списка не сможет писать вам личные сообщения и комментировать ваши записи</p>
									<label for="im-tooltip-popup_checkbox" class="im-tooltip-popup_label-small clearfix">
										<input type="checkbox" name="" id="im-tooltip-popup_checkbox" class="im-tooltip-popup_checkbox">
										Больше не показывать данное предупреждение
									</label>
									<div class="clearfix textalign-c">
										<button class="btn-green">Да</button>
										<button class="btn-gray-light">Нет</button>
									</div>
								</div>
							</div>
							<div class="im-panel-icons_i">
								<a href="" class="im-panel-icons_i-a powertip" title="Удалить диалог">
									<span class="im-panel-ico im-panel-ico__del"></span>
									<span class="im-panel-icons_desc">Удалить <br> диалог</span>
								</a>
							</div>
						</div>
						<div class="im-user-settings clearfix">
							<a class="ava female middle" href="">
								<span class="icon-status status-online"></span>
								<img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg">
							</a>
							<div class="im-user-settings_user">
								<a href="" class="textdec-onhover">Олег Богоявленский</a>
							</div>
						</div>
					</div>
				</div>
				
				<div class="im-center_middle">
					<div class="im-center_middle-hold">
						<div class="im-center_middle-w">
							<div class="im_message-loader">
								<img src="/images/ico/ajax-loader.gif" alt="">
								<span class="im-message-loader_tx">Загрузка ранних сообщений</span>
							</div>
							<div class="im-message clearfix">
								
								<div class="b-control-abs">
									<div class="b-control-abs_hold">
										<div class="clearfix">
											<a class="message-ico message-ico__del powertip" href=""></a>
										</div>
									</div>
									<div class="position-rel clearfix">
										<a class="message-ico message-ico__warning powertip" href=""></a>
										
										<div class="im-tooltip-popup">
											<div class="im-tooltip-popup_t">Укажите вид нарушения:</div>
											<label for="im-tooltip-popup_radio" class="im-tooltip-popup_label clearfix">
											<!-- id у input должны быть все разные, приведен пример для связки label с input
											атрибут name у каждого выпадающего окношка должен быть разный
											  -->
												<input type="radio" name="im-tooltip-popup_radio" id="im-tooltip-popup_radio" class="im-tooltip-popup_radio">
												Спам или реклама
											</label>
											<label for="" class="im-tooltip-popup_label clearfix">
												<input type="radio" name="im-tooltip-popup_radio" id="" class="im-tooltip-popup_radio">
												Мошенничество
											</label>
											<label for="" class="im-tooltip-popup_label clearfix">
												<input type="radio" name="im-tooltip-popup_radio" id="" class="im-tooltip-popup_radio">
												Грубость, угрозы
											</label>
											<label for="" class="im-tooltip-popup_label clearfix">
												<input type="radio" name="im-tooltip-popup_radio" id="" class="im-tooltip-popup_radio">
												Интимный характер
											</label>
											<label for="" class="im-tooltip-popup_label clearfix">
												<input type="radio" name="im-tooltip-popup_radio" id="" class="im-tooltip-popup_radio">
												Другое
											</label>
											<label for="" class="im-tooltip-popup_label clearfix">
												<input type="radio" name="im-tooltip-popup_radio" id="" class="im-tooltip-popup_radio">
												<input type="text" name="" id="" class="im-tooltip-popup_itx" placeholder="Другое">
											</label>
											<div class="clearfix textalign-c">
												<button class="btn-green btn-inactive">Пожаловаться</button>
												<button class="btn-gray-light">Отменить</button>
											</div>
										</div>
									</div>
								</div>
								
								<a class="ava small female" href="">
									<img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg">
								</a>
								<div class="im-message_hold">
									<div class="im-message_t">
										<a href="" class="im-message_user">Олег</a>
										<em class="im-message_date">28 янв 2012, 13:45</em>
										<div class="im-message_status im-message_status__read">Сообщение прочитано</div>
									</div>
									<div class="im-message_tx">
										<!-- Текст может быть отформатирован с помощью абзацев или переводов строки br -->
										<p>Привет! У меня родился сын! Вот фото!
										Уже два года назад стала просматриваться тенденция на неоновые оттенки. <br>  Сначала яркие цвета разнообразили привычные тона лаков для ногтей, и красивые пальчики молодых девушек стали выделяться благодаря красочному маникюру, а потом и губы модниц засветились.</p>
										<p>
										<!-- href указание большого изображения -->
										<!-- rel может быть любым главное у каждого сообщения разный -->
										<a href="/images/example/w220-h165-1.jpg" class="redactor-img" >
										<!-- Превью изображений максимальные размеры  max-height: 110px;  max-width: 170px; -->
											<img src="/images/example/w220-h165-1.jpg" alt="" class="redactor-img_img">
										</a>
										<!-- Превью изображений максимальные размеры  max-height: 110px;  max-width: 170px; -->
										<a href="/images/example/w200-h182-1.jpg" class="redactor-img" >
											<img src="/images/example/w200-h182-1.jpg" alt="" class="redactor-img_img">
										</a>
										</p>
										<p>тенденция на неоновые оттенки. а потом и губы модниц засветились.</p>
									</div>
								</div>
							</div>
							<div class="im-message clearfix">
							
								<div class="b-control-abs">
									<div class="b-control-abs_hold">
										<div class="clearfix">
											<a class="message-ico message-ico__del powertip" href=""></a>
										</div>
									</div>
									<div class="position-rel clearfix">
										<a class="message-ico message-ico__warning powertip" href=""></a>
									</div>
								</div>
								
								<a class="ava small female" href="">
									<img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg">
								</a>
								<div class="im-message_hold">
									<div class="im-message_t">
										<a href="" class="im-message_user">Олег</a>
										<em class="im-message_date">28 янв 2012, 13:45</em>
										<div class="im-message_status im-message_status__read">Сообщение  прочитано</div>
									</div>
									<div class="im-message_tx">Красивые пальчики молодых девушек </div>
								</div>
							</div>
							<div class="im-message clearfix">
							
								<div class="b-control-abs">
									<div class="b-control-abs_hold">
										<div class="clearfix">
											<a class="message-ico message-ico__del powertip" href=""></a>
										</div>
									</div>
									<div class="position-rel clearfix">
										<a class="message-ico message-ico__warning powertip" href=""></a>
									</div>
								</div>
								
								<a class="ava small female" href="">
									<img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg">
								</a>
								<div class="im-message_hold">
									<div class="im-message_t">
										<a href="" class="im-message_user">Анастасия</a>
										<em class="im-message_date">28 янв 2012, 13:45</em>
										<div class="im-message_status im-message_status__noread">Сообщение не прочитано</div>
										<a href="" class="im-message_ico im-message_ico__edit powertip" title="Редактировать"></a>
									</div>
									<div class="im-message_tx">и красивые пальчики молодых девушек стали выделяться благодаря красочному маникюру, а потом и губы модниц засветились 
									</div>
								</div>
							</div>
							
							<div class="im-message clearfix">
								
								<div class="b-control-abs b-control-abs__self">
									<div class="b-control-abs_hold">
										<div class="clearfix">
											<a class="message-ico message-ico__edit powertip" href=""></a>
										</div>
										<div class="clearfix">
											<a class="message-ico message-ico__del powertip" href=""></a>
										</div>
									</div>
								</div>
								
								<a class="ava small female" href="">
									<img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg">
								</a>
								<div class="im-message_hold">
									<div class="im-message_t">
										<a href="" class="im-message_user">Олег</a>
										<em class="im-message_date">28 янв 2012, 13:45</em>
										<div class="im-message_status im-message_status__read">Сообщение прочитано</div>
									</div>
									<div class="im-message_tx">
										Привет! У меня родился сын! Вот фото!
										Уже два года назад стала просматриваться тенденция на неоновые оттенки. Сначала яркие цвета разнообразили привычные тона лаков для ногтей, и красивые пальчики молодых девушек стали выделяться благодаря красочному маникюру, а потом и губы модниц засветились 
										<p>
											<!-- Превью изображений максимальные размеры max-height: 110px;  max-width: 170px; -->
											<a href="/images/example/w200-h182-1.jpg" class="redactor-img">
												<img src="/images/example/w200-h182-1.jpg" alt="" class="redactor-img_img">
											</a>
										</p>
									</div>
									
								</div>
							</div>
							
							
							<div class="im-message im-message__new clearfix">
							
								<div class="b-control-abs">
									<div class="b-control-abs_hold">
										<div class="clearfix">
											<a class="message-ico message-ico__del powertip" href=""></a>
										</div>
									</div>
									<div class="position-rel clearfix">
										<a class="message-ico message-ico__warning powertip" href=""></a>
									</div>
								</div>
								
								<a class="ava small female" href="">
									<img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg">
								</a>
								<div class="im-message_hold">
									<div class="im-message_t">
										<a href="" class="im-message_user">Анастасия</a>
										<em class="im-message_date">28 янв 2012, 13:45</em>
									</div>
									<div class="im-message_tx">
										<!-- Текст может быть отформатирован с помощью абзацев или переносов строки br -->
										<p>Привет! У меня родился сын! Вот фото!</p>
										<p>Уже два года назад стала просматриваться тенденция на неоновые оттенки. Сначала яркие цвета разнообразили привычные тона лаков для ногтей, и красивые пальчики молодых девушек стали выделяться благодаря красочному маникюру, а потом и губы модниц засветились </p>
									</div>
								</div>
							</div>
							<div class="im-message im-message__edited clearfix">
								
								<div class="b-control-abs b-control-abs__self">
									<div class="b-control-abs_hold">
										<div class="clearfix">
											<a class="message-ico message-ico__edit powertip" href=""></a>
										</div>
										<div class="clearfix">
											<a class="message-ico message-ico__del powertip" href=""></a>
										</div>
									</div>
								</div>
								
								<a class="ava small female" href="">
									<img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg">
								</a>
								<div class="im-message_hold">
									<div class="im-message_t">
										<a href="" class="im-message_user">Анастасия</a>
										<em class="im-message_date">28 янв 2012, 13:45</em>
										<div class="im-message_status im-message_status__noread">Сообщение не прочитано</div>
									</div>
									<div class="im-message_tx">
										<!-- Текст может быть отформатирован с помощью абзацев или переносов строки br -->
										<p>Привет! У меня родился сын! Вот фото!</p>
										<p>Уже два года назад стала просматриваться тенденция на неоновые оттенки. Сначала яркие цвета разнообразили привычные тона лаков для ногтей, и красивые пальчики молодых девушек стали выделяться благодаря красочному маникюру, а потом и губы модниц засветились </p>
									</div>
								</div>
							</div>
							
							<div class="im_message-loader">
								<img src="/images/ico/ajax-loader.gif" alt="">
								<span class="im-message-loader_tx">Отправляем сообщение</span>
							</div>
							<div class="im_message-loader">
								<span class="im-message-loader_tx">Олег печатает вам сообщение</span>
								<img src="/images/im/im_message-write-loader.png" alt="" class="im_message-loader-anim">
							</div>
							<div class="im_message-loader">
								Вы можете  <a href="">Отменить</a>  данное сообщение или отредактировать его ниже
							</div>
						</div>
						
					</div>
				</div>
						<script>
$(document).ready(function () { 
  $('.redactor').redactor({
      minHeight: 17,
      autoresize: true,
      focus: true,
      toolbarExternal: '.redactor-control-b_toolbar',
      buttons: ['image', 'video', 'smile'],
      buttonsCustom: {
          smile: {
              title: 'smile',
              callback: function(buttonName, buttonDOM, buttonObject) {
                  // your code, for example - getting code
                  var html = this.get();
              }
          }
      }
  });
});
						</script>		
				<div class="im-center_bottom">
					<div class="im-center_bottom-hold">

						<div class="im-editor-b">
							<a href="" class="ava small im-editor-b_ava"></a>
							
							<div class="im-editor-b_w redactor-control-b wysiwyg-blue">
								<textarea cols="40" id="redactor" name="redactor" class="redactor" rows="1" autofocus></textarea>
								<div class="redactor-control-b_toolbar"></div>
								<div class="redactor-control-b_control">
									<div class="redactor-control-b_key">
										<input type="checkbox" name="" id="redactor-control-b_key-checkbox" class="redactor-control-b_key-checkbox">
										<label for="redactor-control-b_key-checkbox" class="redactor-control-b_key-label">Enter - отправить</label>
									</div>
									<button class="btn-green">Отправить</button>
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
</body>
</html>
