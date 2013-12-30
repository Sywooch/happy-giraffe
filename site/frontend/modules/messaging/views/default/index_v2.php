<div class="im">
	<!-- js ля расчетов положения почты -->
	<script type="text/javascript">
		var im = new function() {
			var self = this;
			function imHeight() {
				// 50 - отступы от im
				var h = self.windowHeight - self.headerHeight - 50;
				if (h < 390) {
					h = 390
				}
				self.imCenter.height(h);
				// 57 - отступ под поле поиска
				self.imUserList.height(h - 57);
			}
			function containerHeight() {
				var h = self.imCenter.height() - self.centerTop.height() - self.centerBottom.height();
				console.log(h, self.container, self.centerTop.height(), self.centerBottom.height());
				self.container.height(h);
			}
			self.renew = function() {
				self.windowHeight = $(window).height();
				imHeight();
				containerHeight();
			}
			
			$(window).resize(function() {
				self.renew();
			});

			$(document).on('koUpdate', 'section.im-center', function(event) {
				var imCenter = this;
				self.imCenter = $(imCenter);
				self.imUserList = $(".im-user-list");
				self.container = $('.im-center_middle-hold', imCenter);
				self.centerTop = $('.im-center_top', imCenter);
				self.centerBottom = $('.im-center_bottom', imCenter);
				self.headerHeight = $('.header').height();
				self.renew();
			});
		}();

	</script>
	<div class="im_hold clearfix" id="<?=$this->id?>_messaging_module">
		<!-- im-sidebar-->
		<section class="im-sidebar clearfix">
			<div class="im-sidebar_panel">
				<!-- side-menu-->
				<div class="side-menu side-menu__im">
                    <div class="side-menu_hold">
						<div class="side-menu_t"></div>
						<a href="" class="side-menu_i active">
							<span class="side-menu_i-hold">
								<span class="side-menu_ico side-menu_ico__all"></span>
								<span class="side-menu_tx">Все</span>
							</span>
							<span class="verticalalign-m-help"></span>
						</a>
						<a href="" class="side-menu_i">
							<span class="side-menu_i-hold">
								<span class="side-menu_ico side-menu_ico__new"></span>
								<span class="side-menu_tx">Новые</span>
								<span class="side-menu_count" data-bind="text: countTotal"></span>
							</span>
							<span class="verticalalign-m-help"></span>
						</a>
						<a href="" class="side-menu_i">
							<span class="side-menu_i-hold">
								<span class="side-menu_ico side-menu_ico__online"></span>
								<span class="side-menu_tx">Кто онлайн</span>
							</span>
							<span class="verticalalign-m-help"></span>
						</a>
						<a href="" class="side-menu_i disabled">
							<span class="side-menu_i-hold">
								<span class="side-menu_ico side-menu_ico__online-friend"></span>
								<span class="side-menu_tx">Друзья онлайн</span>
							</span>
							<span class="verticalalign-m-help"></span>
						</a>
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
                    <div data-bind="css: {scroll: true}">
						<div class="scroll_scroller">
							<div class="scroll_cont" data-bind="foreach: users">
								<div class="im-user-list_i clearfix" data-bind="click: open, css: { active: isActive }">
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
		
		<section class="im-center" data-bind="with: currentThread()">
			<div class="im-center_top">
				<!-- im-panel-->
				<div class="im-panel">
                    <div class="im-panel_actions">
						<div class="im-panel_ico-hold tooltip-click-b">
							<span class="im-panel_ico im-panel_ico__del powertip" title="Удалить диалог" href=""></span>
							<div class="tooltip-drop">
								<div class="tooltip-popup">
									<div class="tooltip-popup_t">Вы уверены?</div>
									<p class="tooltip-popup_tx">Все сообщения из данного диалога будут удалены.</p>
									<label class="tooltip-popup_label-small clearfix" for="im-tooltip-popup_checkbox">
										<input id="im-tooltip-popup_checkbox" class="tooltip-popup_checkbox" type="checkbox" name="">
										Больше не показывать данное предупреждение
									</label>
									<div class="textalign-c clearfix">
										<button class="btn-green">Да</button>
										<button class="btn-gray-light">Нет</button>
									</div>
								</div>
							</div>
						</div>
						<div class="im-panel_ico-hold tooltip-click-b">
							<span class="im-panel_ico im-panel_ico__ban powertip" title="Заблокировать"></span>
							<div class="tooltip-drop">
								<div class="tooltip-popup">
									<div class="tooltip-popup_t">Вы уверены?</div>
									<p class="tooltip-popup_tx">Данный пользователь и весь диалог с ним будут удалены, и он больше не сможет отправлять вам сообщения.</p>
									<label class="tooltip-popup_label-small clearfix" for="im-tooltip-popup_checkbox">
										<input id="im-tooltip-popup_checkbox" class="tooltip-popup_checkbox" type="checkbox" name="">
										Больше не показывать данное предупреждение
									</label>
									<div class="textalign-c clearfix">
										<button class="btn-green" data-bind="click: deleteDialog">Да</button>
										<button class="btn-gray-light">Нет</button>
									</div>
								</div>
							</div>
						</div>
                    </div>
                    <div class="im-panel_user clearfix">
						<a href="" class="ava ava__middle ava__female"><span class="ico-status ico-status__online" data-bind="visible: user.isOnline()"></span><img alt="" data-bind="attr: {src: user.avatar}" class="ava_img"/></a>
						<div class="im-panel_user-status" data-bind="visible: !user.isOnline(), moment: {value: user.lastOnline(), timeAgo: true}"></div>
						<div class="im-panel_user-name" data-bind="text: user.fullName()"></div>
						<!-- У иконки 3 состояния. 
						Друг - без моидфикатора
						Добавить в друзья - .friend__add
						Приглашение отправленно - .friend__added
						-->
						<a href="" class="im-panel_friend im-panel_friend__fr" data-bind="if: user.isFriend"><span class="im-panel_friend-ico"></span><span class="im-panel_friend-tx">Друг</span></a>
						<a href="" class="im-panel_friend im-panel_friend__add" data-bind="if: !user.isFriend()"><span class="im-panel_friend-ico"></span><span class="im-panel_friend-tx">Добавить <br> в друзья</span></a>
                    </div>
				</div>
				<!-- /im-panel-->
			</div>
			<div class="im-center_middle">
				<div data-bind="css: {scroll: true}">
                    <div class="im-center_middle-hold scroll_scroller">
						<div class="im-center_middle-w scroll_cont">
							<div class="im_loader" data-bind="visible: loadingMessages"><img src="/new/images/ico/ajax-loader.gif" alt="" class="im_loader-img"><span class="im_loader-tx">Загрузка ранних сообщений</span></div>
							<!-- ko if: deletedDialogs().length -->
							<!-- cap-empty-->
							<div class="cap-empty cap-empty__abs">
							  <div class="cap-empty_hold">
								<div class="cap-empty_img"></div>
								<div class="cap-empty_t">Диалог с данным пользователем удален</div>
								<div class="cap-empty_tx-sub"><a href='' data-bind="click: restoreDialog">Восстановить</a></div>
							  </div>
							  <div class="verticalalign-m-help"></div>
							</div>
							<!-- /cap-empty-->
							<!-- /ko -->
							<!-- ko foreach: messages -->
								<!-- im-message-->
								<div class="im-message" data-bind="ifnot: hidden">
									<div class="im-message_ava"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online" data-bind="visible: from.isOnline()"></span><img alt="" data-bind="attr: {src: from.avatar}" class="ava_img"/></a>
									</div>
									<div class="im-message_r">
										<div class="im-message_date" data-bind="text: created"></div>
										<div class="im-message_control" data-bind="visible: !dtimeDelete()">
											<!-- b-control-->
											<div class="b-control">
												<div class="b-control_hold">
													<!-- <div class="b-control_i"><a href="" title="В избранное" class="b-control_ico powertip b-control_ico__favorite"></a>
														<div class="b-control_drop"></div>
													</div> -->
													<div class="b-control_i">
														<span class="b-control_ico powertip b-control_ico__delete" href="" title="Удалить" data-bind="click: deleteMessage"></span>
														<div class="b-control_drop"></div>
													</div>
													<div class="b-control_i tooltip-click-b">
														<span class="b-control_ico powertip b-control_ico__spam" href="" title="Пожаловаться"></span>
														<div class="tooltip-drop">
															<div class="tooltip-popup">
																<div class="tooltip-popup_t">Укажите вид нарушения:</div>
																<label class="tooltip-popup_label clearfix" for="tooltip-popup_radio"></label>
																<!-- id у input должны быть все разные, приведен пример для связки label с input атрибут name у каждого выпадающего окношка должен быть разный
																<input id="tooltip-popup_radio" type="radio" name="tooltip-popup_radio" class="tooltip-popup_radio"/>Спам или реклама
																-->
																<label class="tooltip-popup_label clearfix" for="">
																	<input type="radio" class="tooltip-popup_radio" name="tooltip-popup_radio">Мошенничество
																</label>
																<label class="tooltip-popup_label clearfix" for="">
																	<input type="radio" class="tooltip-popup_radio" name="tooltip-popup_radio">Грубость, угрозы
																</label>
																<label class="tooltip-popup_label clearfix" for="">
																	<input type="radio" class="tooltip-popup_radio" name="tooltip-popup_radio">Интимный характер
																</label>
																<label class="tooltip-popup_label clearfix" for="">
																	<input type="radio" class="tooltip-popup_radio" name="tooltip-popup_radio">Другое
																</label>
																<label class="tooltip-popup_label clearfix" for="">
																	<input type="radio" class="tooltip-popup_radio" name="tooltip-popup_radio">
																	<input type="text" class="tooltip-popup_itx" placeholder="Другое" name="">
																</label>
																<div class="clearfix textalign-c">
																	<button class="btn-green btn-inactive">Пожаловаться</button>
																	<button class="btn-gray-light">Отменить</button>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<!-- /b-control-->
										</div>
									</div>
									<div class="im-message_hold">
										<div class="im-message_t"><span class="im-message_name im-message_name__self" data-bind="text: from.fullName()"></span>
										</div>
										<div class="im-message_tx" data-bind="visible: !dtimeDelete(), html: text"></div>
										<div class="im-message_tx color-gray" data-bind="visible: dtimeDelete()">Сообщение удалено. <a href="#" class="font-s" data-bind="click: restore">Восстановить</a></div>
									</div>
								</div>
								<!-- /im-message-->
							<!-- /ko -->
							<!-- im_loader есть всегда, на разные действия в нем менятеся содержимое-->
							<div class="im_loader">
								<!-- ko if: sendingMessage -->
								<img src="/new/images/ico/ajax-loader.gif" alt="" class="im_loader-img"><span class="im_loader-tx">Отправляем сообщение</span>
								<!-- /ko -->
								<!-- ko if: user.typing -->
								<span class="im_loader-tx"><span data-bind="text: user.firstName"></span> печатает вам сообщение</span><img src="/new/images/im/im-message_loader__write.png" alt="" class="im_loader-anim">
								<!-- /ko -->
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
			<!-- im-center_bottom-->
			<div class="im-center_bottom">
				<div class="im-center_bottom-w clearfix">
                    <div class="im-center_bottom-ava"><a href="" class="ava ava__middle ava__female"><span class="ico-status ico-status__online"></span><img alt="" data-bind="attr: {src: me.avatar}" class="ava_img"/></a>
                    </div>
                    <div class="im-center_bottom-hold">
						<!-- По клику на input заменять на wysiwyg -->
						<!-- ko ifnot: editing -->
						<input type="text" placeholder="Введите ваше сообщение" class="im-center_bottom-itx" data-bind="click: setEditing" />
						<!-- /ko -->
						<!-- ko if: editing -->
						<div class="redactor-control">
							<textarea cols="40" name="redactor" rows="1" autofocus="autofocus" class="redactor" data-bind="value: editor"></textarea>
							<div class="redactor-control_toolbar"></div>
							<div class="redactor-control_control">
								<div class="redactor-control_key">
									<input type="checkbox" name="" class="redactor-control_key-checkbox"/>
									<label for="redactor-control-b_key-checkbox" class="redactor-control_key-label">Enter - отправить</label>
								</div>
								<button class="btn-green" data-bind="click: sendMessage">Отправить</button>
							</div>
						</div>
						<!-- /ko -->
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