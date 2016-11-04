<div id="fastMessage" class="msg-fast popup">
	<div class="msg-fast_hold">
		<div class="msg-fast_top">
            <div class="msg-fast_t">Написать сообщение</div>
            <div class="msg-fast_row clearfix">
				<div class="msg-fast_whom">Кому:</div>
				<!-- im-panel-->
				<div class="im-panel im-panel__small">
					<div class="im-panel_user clearfix">
						<a href="" class="ava ava__middle ava__female"><span class="ico-status ico-status__online" data-bind="visible: user.isOnline()"></span><img alt="" data-bind="attr: {src: user.avatar}" class="ava_img"/></a>
						<div class="im-panel_hold">
							<div class="im-panel_user-status" data-bind="visible: !user.isOnline()"><span data-bind="text: user.gender ? 'Был на сайте' : 'Была на сайте'"></span> <span data-bind="moment: {value: user.lastOnline(), timeAgo: true}"></span></div>
							<a href="" class="im-panel_user-name" data-bind="text: user.fullName()">Александр Богоявлен Богоявленский</a>
						</div>
						<!-- У иконки 3 состояния. 
						Друг - без моидфикатора
						Добавить в друзья - .friend__add
						Приглашение отправленно - .friend__added
						-->
						<a href="" class="im-panel_friend im-panel_friend__fr" data-bind="if: user.isFriend"><span class="im-panel_friend-ico"></span><span class="im-panel_friend-tx">Друг</span></a>
						<a href="" class="im-panel_friend im-panel_friend__add" data-bind="if: !user.isFriend()"><span class="im-panel_friend-ico"></span><span class="im-panel_friend-tx">Добавить <br> в друзья</span></a>
					</div>
				</div>
				<!-- /im-panel--><a class="i-more i-more__small">В диалоги</a>
            </div>
		</div>
		<div class="msg-fast_b">
            <div class="redactor-control">
				<div class="redactor-control_hold">
					<div class="scroll">
						<div class="scroll_scroller">
							<!-- Width из-за открытия в попапе, прикручивая ненужен-->
							<div style="width:468px;" class="scroll_cont">
								<!-- после открытия попапа передавать фокус на редактор-->
								<textarea cols="40" name="redactor" rows="1" autofocus="autofocus" class="redactor" data-bind="value: editor"></textarea>
							</div>
							<div class="scroll_bar-hold">
								<div class="scroll_bar">
									<div class="scroll_bar-in"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="redactor-control_toolbar_526" class="redactor-control_toolbar clearfix"></div>
				<div class="redactor-control_control">
					<div class="redactor-control_key">
						<input type="checkbox" name="" class="redactor-control_key-checkbox"/>
						<label for="redactor-control-b_key-checkbox" class="redactor-control_key-label">Enter - отправить</label>
					</div>
					<button class="btn-green" data-bind="click: sendMessage">Отправить</button>
				</div>
            </div>
		</div>
	</div>
	<div class="cap-empty cap-empty__abs cap-empty__blue" data-bind="visible: sendingMessage">
		<div class="cap-empty_abs-msg">
            <div class="cap-empty_abs-msg-hold">Отправка <img src='/new/images/ico/ajax-loader.gif' class='ico-loader'></div>
		</div>
	</div>
	<div class="cap-empty cap-empty__abs cap-empty__blue" data-bind="visible: isSuccess">
		<div class="cap-empty_abs-msg">
            <div class="cap-empty_abs-msg-hold">Сообщение отправлено</div>
		</div>
	</div>
</div>