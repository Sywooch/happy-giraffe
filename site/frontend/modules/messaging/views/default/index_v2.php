<div class="im">
	<!-- js ля расчетов положения почты -->
	<script type="text/javascript">
		var im = []
		im.imHeight = function () {
			// 50 - отступы от im
			var h = im.windowHeight - im.headerHeight - 50; 
			if (h < 390) {
				h = 390;
			}

			im.imCenter.height(h);
			// 57 - отступ под поле поиска
			im.imUserList.height(h - 57);
		}
		im.containerHeight = function() {
			var h = im.imCenter.height() - im.centerTop.height() - im.centerBottom.height();
			im.container.height(h);
		}
		$(document).ready(function () {
			im.windowHeight = $(window).height(); 
			im.imCenter = $(".im-center");
			im.imUserList = $(".im-user-list");

			im.container = $('.im-center_middle-hold');

			im.centerTop = $('.im-center_top');
			im.centerBottom = $('.im-center_bottom');

			im.headerHeight = $('.header').height();

			im.imHeight();
			im.containerHeight();

			$(window).resize(function() {
				im.windowHeight = $(window).height();
				im.imHeight();
				im.containerHeight();
			});
		});

	</script>
	<div class="im_hold clearfix" id="<?=$this->id?>_messaging_module">
		<!-- im-sidebar-->
		<section class="im-sidebar clearfix">
			<div class="im-sidebar_panel">
				<!-- side-menu-->
				<div class="side-menu side-menu__im">
                    <div class="side-menu_hold">
						<div class="side-menu_t"></div><a href="" class="side-menu_i active"><span class="side-menu_i-hold"><span class="side-menu_ico side-menu_ico__all"></span><span class="side-menu_tx">Все</span></span><span class="verticalalign-m-help"></span></a><a href="" class="side-menu_i"><span class="side-menu_i-hold"><span class="side-menu_ico side-menu_ico__new"></span><span class="side-menu_tx">Новые</span><span class="side-menu_count">59</span></span><span class="verticalalign-m-help"></span></a><a href="" class="side-menu_i"><span class="side-menu_i-hold"><span class="side-menu_ico side-menu_ico__online"></span><span class="side-menu_tx">Кто онлайн</span></span><span class="verticalalign-m-help"></span></a><a href="" class="side-menu_i disabled"><span class="side-menu_i-hold"><span class="side-menu_ico side-menu_ico__online-friend"></span><span class="side-menu_tx">Друзья онлайн</span></span><span class="verticalalign-m-help"></span></a>
                    </div>
				</div>
				<!-- /side-menu-->
				<div class="im-sidebar_sound"><a href="" class="im-sidebar_sound-ico"></a></div>
			</div>
			<div class="im-sidebar_users">
				<div class="im-sidebar_search clearfix">
                    <input type="text" name="" placeholder="Поиск диалогов" class="im-sidebar_search-itx"/>
                    <button class="im-sidebar_search-btn"></button>
				</div>
				<!-- im-user-list-->
				<div class="im-user-list">
                    <div class="scroll">
						<div class="scroll_scroller">
							<div class="scroll_cont" data-bind="foreach: users">
								<!--<div class="im-user-list_i clearfix active">-->
								<div class="im-user-list_i clearfix" data-bind="click: open">
									<div class="im-user-list_count" data-bind="visible: countNew() > 0, text: countNew"></div>
									<div class="im-user-list_set"><a href="" class="ava ava__middle ava__female"><span class="ico-status ico-status__online" data-bind="visible: isOnline"></span><img alt="" data-bind="attr: {src: avatar}" class="ava_img"/></a>
										<div class="im-user-list_set-name"><a href="" class="im-user-list_set-a" data-bind="text: fullName()"></a></div>
									</div>
								</div>
							</div>
						</div>
						<div class="scroll_bar-hold">
							<div class="scroll_bar">
								<div class="scroll_bar-in"></div>
							</div>
						</div>
                    </div>
				</div>
				<!-- /im-user-list-->
			</div>
		</section>
		<!-- /im-sidebar-->
		<!-- im-center-->
		<section class="im-center">
			<div class="im-center_top">
				<!-- im-panel-->
				<div class="im-panel">
                    <div class="im-panel_actions">
						<div class="im-panel_ico-hold"><a href="" title="Удалить диалог" class="im-panel_ico im-panel_ico__del powertip"></a>
							<div class="im-panel_drop"></div>
						</div>
						<div class="im-panel_ico-hold"><a href="" title="Заблокировать" class="im-panel_ico im-panel_ico__ban powertip"></a>
							<div class="im-panel_drop"></div>
						</div>
                    </div>
                    <div class="im-panel_user clearfix">
						<!-- Если пользователь online .im-panel_user-status не нужнен, а в .ava .ico-status.ico-status__online--><a href="" class="ava ava__middle ava__female"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"/></a>
						<div class="im-panel_user-status">Был на сайте 2 мин назад</div>
						<div class="im-panel_user-name">Александр Богоявленский</div>
						<!-- У иконки 3 состояния. 
						Друг - без моидфикатора
						Добавить в друзья - .friend__add
						Приглашение отправленно - .friend__added
						--><a href="" class="im-panel_friend im-panel_friend__add"><span class="im-panel_friend-ico"></span><span class="im-panel_friend-tx">Добавить <br> в друзья</span></a>
                    </div>
				</div>
				<!-- /im-panel-->
			</div>
			<div class="im-center_middle">
				<div class="scroll">
                    <div class="im-center_middle-hold scroll_scroller">
						<div class="im-center_middle-w scroll_cont">
							<div class="im_loader"><img src="/images/ico/ajax-loader.gif" alt="" class="im_loader-img"><span class="im_loader-tx">Загрузка ранних сообщений</span></div>
							<!-- im-message-->
							<div class="im-message">
								<div class="im-message_ava"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"/></a>
								</div>
								<div class="im-message_r">
									<div class="im-message_date">Вчера 13:45</div>
									<div class="im-message_control">
										<!-- b-control-->
										<div class="b-control">
											<div class="b-control_hold">
												<div class="b-control_i"><a href="" title="В избранное" class="b-control_ico powertip b-control_ico__favorite"></a>
													<div class="b-control_drop"></div>
												</div>
												<div class="b-control_i"><a href="" title="Удалить" class="b-control_ico powertip b-control_ico__delete"></a>
													<div class="b-control_drop"></div>
												</div>
												<div class="b-control_i"><a href="" title="Пожаловаться" class="b-control_ico powertip b-control_ico__spam"></a>
													<div class="b-control_drop"></div>
												</div>
											</div>
										</div>
										<!-- /b-control-->
									</div>
								</div>
								<div class="im-message_hold">
									<div class="im-message_t"><span class="im-message_name im-message_name__self">Александр Богоявленский</span>
									</div>
									<div class="im-message_tx">

										я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически производит поиск по сайту и подцепляет естественно студийные версии песен вместо нужных.  я не нашел, где можно поменять название трека. Меняя название трека в альбоме он
									</div>
								</div>
							</div>
							<!-- /im-message-->
							<!-- im-message-->
							<div class="im-message">
								<div class="im-message_ava"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"/></a>
								</div>
								<div class="im-message_r">
									<div class="im-message_date">Вчера 13:45</div>
									<div class="im-message_control">
										<!-- b-control-->
										<div class="b-control">
											<div class="b-control_hold">
												<div class="b-control_i"><a href="" title="В избранное" class="b-control_ico powertip b-control_ico__favorite"></a>
													<div class="b-control_drop"></div>
												</div>
												<div class="b-control_i"><a href="" title="Удалить" class="b-control_ico powertip b-control_ico__delete"></a>
													<div class="b-control_drop"></div>
												</div>
												<div class="b-control_i"><a href="" title="Пожаловаться" class="b-control_ico powertip b-control_ico__spam"></a>
													<div class="b-control_drop"></div>
												</div>
											</div>
										</div>
										<!-- /b-control-->
									</div>
								</div>
								<div class="im-message_hold">
									<div class="im-message_t"><span class="im-message_name im-message_name__friend">Александр Богоявленский</span>
									</div>
									<div class="im-message_tx">

										я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически производит поиск по сайту и подцепляет естественно студийные версии песен вместо нужных.  я не нашел, где можно поменять название трека. Меняя название трека в альбоме он
									</div>
								</div>
							</div>
							<!-- /im-message-->
							<!-- im-message-->
							<div class="im-message">
								<div class="im-message_ava"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"/></a>
								</div>
								<div class="im-message_r">
									<div class="im-message_date">Вчера 13:45</div>
									<div class="im-message_control">
										<!-- b-control-->
										<div class="b-control">
											<div class="b-control_hold">
												<div class="b-control_i"><a href="" title="Удалить" class="b-control_ico powertip b-control_ico__delete"></a>
													<div class="b-control_drop"></div>
												</div>
											</div>
										</div>
										<!-- /b-control-->
									</div>
								</div>
								<div class="im-message_hold">
									<div class="im-message_t"><span class="im-message_name im-message_name__self">Александр Богоявленский</span>
									</div>
									<div class="im-message_tx">

										я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически производит поиск по сайту и подцепляет естественно студийные версии песен вместо нужных.  я не нашел, где можно поменять название трека. Меняя название трека в альбоме он
									</div>
								</div>
							</div>
							<!-- /im-message-->
							<!-- im-message-->
							<div class="im-message">
								<div class="im-message_ava"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"/></a>
								</div>
								<div class="im-message_r">
									<div class="im-message_date">Вчера 13:45</div>
									<div class="im-message_control">
										<!-- b-control-->
										<div class="b-control">
											<div class="b-control_hold">
											</div>
										</div>
										<!-- /b-control-->
									</div>
								</div>
								<div class="im-message_hold">
									<div class="im-message_t"><span class="im-message_name im-message_name__self">Александр Богоявленский</span>
									</div>
									<div class="im-message_tx color-gray">Сообщение удалено. <a href="#" class="font-s">Восстановить</a></div>
								</div>
							</div>
							<!-- /im-message-->
							<!-- im-message-->
							<div class="im-message">
								<div class="im-message_ava"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"/></a>
								</div>
								<div class="im-message_r">
									<div class="im-message_date">Вчера 13:45</div>
									<div class="im-message_control">
										<!-- b-control-->
										<div class="b-control">
											<div class="b-control_hold">
											</div>
										</div>
										<!-- /b-control-->
									</div>
								</div>
								<div class="im-message_hold">
									<div class="im-message_t"><span class="im-message_name im-message_name__self">Александр Богоявленский</span>
									</div>
									<!-- Когда сообщение отменено или удалено то блок .b-control удалется из сообщения или к нему добавляется класс display-n-->
									<div class="im-message_tx color-gray">Сообщение отменено.</div>
								</div>
							</div>
							<!-- /im-message-->
							<!-- im-message-->
							<div class="im-message">
								<div class="im-message_ava"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"/></a>
								</div>
								<div class="im-message_r">
									<div class="im-message_date">Вчера 13:45</div>
									<div class="im-message_control">
										<!-- b-control-->
										<div class="b-control">
											<div class="b-control_hold">
												<div class="b-control_i"><a href="" title="Удалить" class="b-control_ico powertip b-control_ico__delete"></a>
													<div class="b-control_drop"></div>
												</div>
											</div>
										</div>
										<!-- /b-control-->
									</div>
								</div>
								<div class="im-message_hold">
									<div class="im-message_t"><span class="im-message_name im-message_name__self">Александр Богоявленский</span><span class="im-message_t-read">Сообщение прочитано</span>
									</div>
									<div class="im-message_tx">

										я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически производит поиск по сайту и подцепляет естественно студийные версии песен вместо нужных.  я не нашел, где можно поменять название трека. Меняя название трека в альбоме он
									</div>
								</div>
							</div>
							<!-- /im-message-->
							<!-- im-message-->
							<div class="im-message">
								<div class="im-message_ava"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"/></a>
								</div>
								<div class="im-message_r">
									<div class="im-message_date">Вчера 13:45</div>
									<div class="im-message_control">
										<!-- b-control-->
										<div class="b-control">
											<div class="b-control_hold">
												<div class="b-control_i"><a href="" title="Редактировать" class="b-control_ico powertip b-control_ico__edit"></a>
													<div class="b-control_drop"></div>
												</div>
												<div class="b-control_i"><a href="" title="Отменить" class="b-control_ico powertip b-control_ico__cancel"></a>
													<div class="b-control_drop"></div>
												</div>
											</div>
										</div>
										<!-- /b-control-->
									</div>
								</div>
								<div class="im-message_hold">
									<div class="im-message_t"><span class="im-message_name im-message_name__self">Александр Богоявленский</span><span class="im-message_t-read-no">Сообщение не прочитано</span>
									</div>
									<div class="im-message_tx">

										я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически производит поиск по сайту и подцепляет естественно студийные версии песен вместо нужных.  я не нашел, где можно поменять название трека. Меняя название трека в альбоме он
									</div>
								</div>
							</div>
							<!-- /im-message-->
							<!-- im_loader есть всегда, на разные действия в нем менятеся содержимое-->
							<div class="im_loader"><img src="/images/ico/ajax-loader.gif" alt="" class="im_loader-img"><span class="im_loader-tx">Отправляем сообщение</span></div>
							<div class="im_loader"><span class="im_loader-tx">Олег печатает вам сообщение</span><img src="/images/im/im-message_loader__write.png" alt="" class="im_loader-anim"></div>
						</div>
                    </div>
                    <div class="scroll_bar-hold">
						<div class="scroll_bar">
							<div class="scroll_bar-in"></div>
						</div>
                    </div>
				</div>
			</div>
			<!-- im-center_bottom-->
			<div class="im-center_bottom">
				<div class="im-center_bottom-w clearfix">
                    <div class="im-center_bottom-ava"><a href="" class="ava ava__middle ava__female"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"/></a>
                    </div>
                    <div class="im-center_bottom-hold">
						<!-- По клику на input заменять на wysiwyg -->
						<input type="text" placeholder="Введите ваше сообщение" class="im-center_bottom-itx"/>
                    </div>
				</div>
			</div>
			<!-- /im-center_bottom-->
		</section>
		<!-- /im-center-->
	</div>
</div>
<script type="text/javascript">
	$(function() {
		ko.applyBindings(new Messaging(<?=$data?>), document.getElementById(<?=$this->id?>_messaging_module));
	});
</script>