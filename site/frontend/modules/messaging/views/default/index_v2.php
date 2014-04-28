<?php $this->widget('PhotoCollectionViewWidget', array('registerScripts' => true)); ?>

<div class="layout-wrapper_hold clearfix">
    <div class="im" style="display: none" data-bind="attr: { 'style': '' }" id="<?=$this->id?>_messaging_module">
        <!-- js для расчетов положения почты -->
        <script type="text/javascript">
            var im = new function() {
                var self = this;
                function imHeight() {
                    // 50 - отступы от im
                    var h = self.windowHeight - self.headerHeight - 40;
                    if (h < 390) {
                        h = 390
                    }
                    self.imCenter.height(h);
                    // 57 - отступ под поле поиска
                    self.imUserList.height(h - 57);
                }
                function containerHeight() {
                    var h = self.imCenter.height() - self.centerTop.height() - self.centerBottom.height();
                    self.container.height(h);
                }
				function msgToBottom() {
					var contH = self.container.height();
					var contWrapH = self.contWrap.height();

					if (contH > contWrapH) {
						var h = contH - contWrapH - 5;
						self.contWrap.css({'padding-top': h});
					} else {
						self.contWrap.css({'padding-top': 0});
					}
				}
                self.renew = function() {
                    self.windowHeight = $(window).height();
					self.headerHeight = $('.layout-header').height();
                    imHeight();
                    containerHeight();
					msgToBottom();
                    // стриггерим события прокрутки, после изменения размеров
                    self.container.find('.scroll_scroller').trigger('scroll');
                    self.imCenter.find('.scroll_scroller').trigger('scroll');
                    self.imUserList.find('.scroll_scroller').trigger('scroll');
                }

                $(window).resize(function() {
                    self.renew();
                });

                $(document).on('koUpdate', 'section.im-center', function(event) {
                    if(event.target == this)
                    {
                        var imCenter = this;
                        self.imCenter = $(imCenter);
                        self.imUserList = $(".im-user-list");
                        self.container = $('.im-center_middle-hold', imCenter);
                        self.centerTop = $('.im-center_top', imCenter);
                        self.centerBottom = $('.im-center_bottom', imCenter);
                        self.headerHeight = $('.layout-header').height();
						self.contWrap = $('.im-center_middle-w', imCenter);
                        self.renew();
                    }
                });
            }();

        </script>
        <div class="im_hold clearfix">
            <!-- im-sidebar-->
            <section class="im-sidebar clearfix" data-bind="with: contactsManager">
                <div class="im-sidebar_panel">
                    <!-- side-menu-->
                    <div class="side-menu side-menu__im">
                        <div class="side-menu_hold">
                            <div class="side-menu_t"></div>
                            <ul class="side-menu_ul">
                                <li class="side-menu_li" data-bind="css: {active: currentFilter() == 0}">
                                    <a href="" class="side-menu_i" data-bind="click: function() {setFilter(0);}, css: {active: currentFilter() == 0}">
                                        <span class="side-menu_i-hold">
                                            <span class="side-menu_ico side-menu_ico__all"></span>
                                            <span class="side-menu_tx">Все</span>
                                        </span>
                                        <span class="verticalalign-m-help"></span>
                                    </a>
                                </li>
                                <li class="side-menu_li" data-bind="css: {active: currentFilter() == 1}">
                                    <a href="" class="side-menu_i" data-bind="click: function() {setFilter(1);}">
                                        <span class="side-menu_i-hold">
                                            <span class="side-menu_ico side-menu_ico__new"></span>
                                            <span class="side-menu_tx">Новые</span>
                                            <span class="side-menu_count" data-bind="text: countTotal, visible: countTotal() > 0"></span>
                                        </span>
                                        <span class="verticalalign-m-help"></span>
                                    </a>
                                </li>
                                <li class="side-menu_li" data-bind="css: {active: currentFilter() == 2}">
                                    <a href="" class="side-menu_i" data-bind="click: function() {setFilter(2);}">
                                        <span class="side-menu_i-hold">
                                            <span class="side-menu_ico side-menu_ico__online"></span>
                                            <span class="side-menu_tx">Кто онлайн</span>
                                        </span>
                                        <span class="verticalalign-m-help"></span>
                                    </a>
                                </li>
                                <!--<li class="side-menu_li" data-bind="css: {active: currentFilter() == 3}">
                                    <a href="" class="side-menu_i" data-bind="click: function() {setFilter(3);}">
                                        <span class="side-menu_i-hold">
                                            <span class="side-menu_ico side-menu_ico__online-friend"></span>
                                            <span class="side-menu_tx">Друзья онлайн</span>
                                        </span>
                                        <span class="verticalalign-m-help"></span>
                                    </a>
                                </li>-->
                            </ul>
                        </div>
                    </div>
                    <!-- /side-menu-->
                    <div class="im-sidebar_sound"><a class="im-sidebar_sound-ico" data-bind="click: function() {$parent.settings.toggle('messaging__sound')}, css: { inactive : ! $parent.settings.messaging__sound() }"></a></div>
                </div>
                <div class="im-sidebar_users">
                    <div class="im-sidebar_search clearfix">
                        <input type="text" name="" placeholder="Поиск диалогов" data-bind="value: search, valueUpdate: 'keyup'" class="im-sidebar_search-itx"/>
                        <button class="im-sidebar_search-btn" data-bind="click: clearSearch, css: { active : search().length > 0 }"></button>
                    </div>
                    <!-- im-user-list-->
                    <div class="im-user-list">
                        <div data-bind="css: {scroll: true}">
                            <div class="scroll_scroller" data-bind="show: {selector: '.im-user-list_i:not(.bySearching):gt(-10), .im-user-list_i.bySearching, .cap-empty', callback: loadContacts}">
                                <div class="scroll_cont">
                                    <!-- ko foreach: filtered -->
                                        <div class="im-user-list_i clearfix" data-bind="visible: isShow, click: open, css: { active: isActive, bySearching: bySearching() && $parent.currentFilter() !== 4 }">
                                            <div class="im-user-list_count" data-bind="visible: countNew() > 0, text: countNew"></div>
                                            <div class="im-user-list_set"><a href="" class="ava ava__middle ava__female"><span class="ico-status ico-status__online" data-bind="visible: isOnline"></span><img alt="" data-bind="attr: {src: avatar}" class="ava_img"/></a>
                                                <div class="im-user-list_set-name"><a href="" class="im-user-list_set-a" data-bind="text: fullName()"></a></div>
                                            </div>
                                        </div>
                                    <!-- /ko -->
                                    <!-- ko if: loadindContacts -->
                                        <div class="im_loader"><img src="/images/ico/ajax-loader.gif" alt="" class="im_loader-img"><span class="im_loader-tx">Загрузка пользователей</span></div>
                                    <!-- /ko -->
                                    <!-- ko if: filtered().length == 0 -->
                                        <!-- cap-empty-->
                                        <div class="cap-empty">
                                            <div class="cap-empty_hold">
                                                <div class="cap-empty_img"></div>
                                                <!-- ko if: currentFilter() == 4 -->
                                                <div class="cap-empty_tx-sub">По данному запросу <br> контактов не найдено.</div>
                                                <!-- /ko -->
                                                <!-- ko if: currentFilter() != 4 -->
                                                <div class="cap-empty_tx-sub">Список пуст.</div>
                                                <!-- /ko -->
                                            </div>
                                            <div class="verticalalign-m-help"></div>
                                        </div>
                                        <!-- /cap-empty-->
                                    <!-- /ko -->
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
                <!-- ko if: $parent.me.avatar() === false -->
                    <!-- cap-empty-->
                    <div class="cap-empty cap-empty__abs cap-empty__im-ava">
                        <div class="cap-empty_hold">
                            <div class="cap-empty_img"></div>
                            <!-- ko if: messages().length == 0 -->
                            <div class="cap-empty_t">Для того, чтобы начать диалог необходимо <br /> загрузить свое главное фото</div>
                            <div class="cap-empty_tx-sub"><a href="<?=Yii::app()->user->model->getUrl()?>" class="file-fake_btn btn-green btn-m" target="_blank">Загрузить фото</a></div>
                            <!-- /ko -->
                            <!-- ko if: messages().length > 0 -->
                            <div class="cap-empty_t">У вас есть непрочитанные сообщения</div>
                            <div class="cap-empty_tx-sub">Для того, чтобы начать пользоваться сервисом, <br />необходимо загрузить свое главное фото <br /><a href="<?=Yii::app()->user->model->getUrl()?>" class="btn-green btn-m" target="_blank">Загрузить фото</a></div>
                            <!-- /ko -->
                        </div>
                        <div class="verticalalign-m-help"></div>
                    </div>
                    <!-- /cap-empty-->
                <!-- /ko -->

                <div class="im-center_top">
                    <!-- im-panel-->
                    <div class="im-panel">
                        <div class="im-panel_actions">
                            <div class="im-panel_ico-hold" data-bind="visible: $root.notConfirmDelete()">
                                <span class="im-panel_ico im-panel_ico__del" title="Удалить диалог" data-bind="click: function(thread) { thread.me.viewModel.notConfirmDelete() ? thread.deleteDialog() : 'nothing';}"></span>
                            </div>
                            <div class="im-panel_ico-hold tooltip-click-b" data-bind="visible: !$root.notConfirmDelete()">
                                <span class="im-panel_ico im-panel_ico__del powertip" title="Удалить диалог"></span>
                                <div class="tooltip-drop">
                                    <div class="tooltip-popup">
                                        <div class="tooltip-popup_t">Вы уверены?</div>
                                        <p class="tooltip-popup_tx">Все сообщения из данного диалога будут удалены.</p>
                                        <label class="tooltip-popup_label-small clearfix" for="im-tooltip-popup_checkbox" data-bind="with: $root">
                                            <input id="im-tooltip-popup_checkbox" class="tooltip-popup_checkbox" type="checkbox" name="" data-bind="checked: notConfirmDelete">
                                            Больше не показывать данное предупреждение
                                        </label>
                                        <div class="textalign-c clearfix">
                                            <button class="btn-green" data-bind="click: function(thread, event){ thread.deleteDialog(); $('.tooltip-click-b').tooltipster('hide');}">Да</button>
                                            <button class="btn-gray-light" onclick="$('.tooltip-click-b').tooltipster('hide');">Нет</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--
                            <div class="im-panel_ico-hold tooltip-click-b">
                                <span class="im-panel_ico im-panel_ico__ban powertip" title="Заблокировать" data-bind="click: user.blackListHandler, css: { active : user.blackListed }"></span>
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
                            -->
                        </div>
                        <div class="im-panel_user clearfix">
                            <a class="ava ava__middle ava__female" data-bind="attr: { href : user.profileUrl }" target="_blank"><span class="ico-status ico-status__online" data-bind="visible: user.isOnline()"></span><img alt="" data-bind="attr: {src: user.avatar}" class="ava_img"/></a>
                            <div class="im-panel_user-status" data-bind="visible: !user.isOnline()"><span data-bind="text: user.gender ? 'Был на сайте' : 'Была на сайте'"></span> <span data-bind="moment: {value: user.lastOnline(), timeAgo: true}"></span></div>
                            <a class="im-panel_user-name" data-bind="text: user.fullName(), attr: { href : user.profileUrl }" target="_blank"></a>
                            <span data-bind="module: {name: 'friend', data: user, template: 'friend/button'}"></span>
                        </div>
                    </div>
                    <!-- /im-panel-->
                </div>
                <div class="im-center_middle">
                    <div data-bind="css: {scroll: true}">
                        <div class="im-center_middle-hold scroll_scroller" data-bind="show: [{selector: '.im-message:lt(10)', callback: loadMessages}, {selector: '.im-message__new', callback: function() { ko.dataFor(this) ? ko.dataFor(this).show() : true; } }], hide: {selector: '.im-message__new', callback: function() { ko.dataFor(this) ? ko.dataFor(this).hide() : true; } }, fixScroll: {manager: scrollManager, type: 'box'}">
                            <div class="im-center_middle-w scroll_cont">
                                <div class="im_loader" data-bind="visible: loadingMessages"><img src="/new/images/ico/ajax-loader.gif" alt="" class="im_loader-img"><span class="im_loader-tx">Загрузка ранних сообщений</span></div>
                                <!-- ko if: deletedDialogs().length -->
                                <!-- cap-empty-->
                                <div class="cap-empty" data-bind="css: {'cap-empty__abs': ko.utils.arrayFilter(messages(), function(m) { return !m.hidden(); }).length == 0 }">
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
                                    <div class="im-message" data-bind="visible: !hidden(), css: {'im-message__stick': isStick($parent.messages(), $index()), 'im-message__new': !isMy && !dtimeRead(), 'im-message__edited': $parent.editingMessage() == $data}, fixScroll: {manager: $parent.scrollManager, type: 'element', model: $data}">
                                        <div class="im-message_ava"><a href="" class="ava ava__small ava__male" data-bind="attr: { href : from.profileUrl }" target="_blank"><span class="ico-status ico-status__online" data-bind="visible: from.isOnline()"></span><img alt="" data-bind="attr: {src: from.avatar}" class="ava_img"/></a>
                                        </div>
                                        <div class="im-message_r">
                                            <div class="im-message_date" data-bind="moment: created"></div>
                                            <div class="im-message_control" data-bind="visible: !dtimeDelete() && !cancelled()">
                                                <!-- b-control-->
                                                <div class="b-control">
                                                    <div class="b-control_hold">
                                                        <!-- <div class="b-control_i"><a href="" title="В избранное" class="b-control_ico powertip b-control_ico__favorite"></a>
                                                            <div class="b-control_drop"></div>
                                                        </div> -->
                                                        <div class="b-control_i">
                                                            <span class="b-control_ico powertip b-control_ico__delete" href="" data-tooltip="Удалить" title="Удалить" data-bind="click: deleteMessage, css: {'display-n': !canDelete()}"></span>
                                                            <div class="b-control_drop"></div>
                                                        </div>
                                                        <div class="b-control_i tooltip-click-b" data-bind="css: {'display-n' : isMy || reported()}">
                                                            <span class="b-control_ico powertip b-control_ico__spam" data-tooltip="Пожаловаться" title="Пожаловаться" data-bind="click: report"></span>
                                                            <!--<div class="tooltip-drop">
                                                                <div class="tooltip-popup">
                                                                    <div class="tooltip-popup_t">Укажите вид нарушения:</div>
                                                                    <label class="tooltip-popup_label clearfix" for="tooltip-popup_radio"></label>
                                                                    <!-- id у input должны быть все разные, приведен пример для связки label с input атрибут name у каждого выпадающего окношка должен быть разный
                                                                    <input id="tooltip-popup_radio" type="radio" name="tooltip-popup_radio" class="tooltip-popup_radio"/>Спам или реклама
                                                                    --><!--
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
                                                            </div>-->
                                                        </div>
                                                        <div class="b-control_i" data-bind="click: beginEditing, scrollTo: 'click', css: {'display-n' : !canEdit()}"><span data-tooltip="Редактировать" title="Редактировать" class="b-control_ico powertip b-control_ico__edit"></span>
                                                            <div class="b-control_drop"></div>
                                                        </div>
                                                        <div class="b-control_i" data-bind="click: cancelMessage,css: {'display-n' : !canCancel()}"><span data-tooltip="Отменить" title="Отменить" class="b-control_ico powertip b-control_ico__cancel"></span>
                                                            <div class="b-control_drop"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /b-control-->
                                            </div>
                                        </div>
                                        <div class="im-message_hold">
                                            <div class="im-message_t">
                                                <span class="im-message_name" data-bind="text: from.fullName(), css: { 'im-message_name__self': isMy, 'im-message_name__friend': !isMy}"></span>
                                                <!--<span class="im-message_t-read" data-bind="visible: isMy && dtimeRead() && $parent.lastReadMessage() == $data">Сообщение прочитано</span>-->
                                                <span class="im-message_t-read-no" data-bind="visible: isMy && !dtimeRead() && !cancelled()">Сообщение не прочитано</span>
                                            </div>
                                            <div class="im-message_tx" data-bind="visible: !dtimeDelete() && !cancelled(), html: text"></div>
                                            <div class="im-message_tx color-gray" data-bind="visible: dtimeDelete()">Сообщение удалено. <a href="#" class="font-s" data-bind="click: restore">Восстановить</a></div>
                                            <div class="im-message_tx color-gray-light" data-bind="visible: cancelled()">Сообщение отменено.</div>
                                        </div>
                                    </div>
                                    <!-- /im-message-->
                                <!-- /ko -->
                                <div data-bind="module: { name: 'friend', data: user, template: 'friend/tile'}"></div>
                                <? /* <!-- ko if: user.friendsState() == user.FRIENDS_STATE_OUTGOING -->
                                <div class="friend-offer">
                                    <div class="friend-offer_hold">
                                        <div class="friend-offer_ava"><a href="" class="ava ava__middle ava__female"><span class="ico-status ico-status__online" data-bind="visible: user.isOnline()"></span><img alt="" data-bind="attr: {src: user.avatar}" class="ava_img"/></a></a>
                                        </div>
                                        <div class="friend-offer_in"><a class="friend-offer_name" data-bind="text: user.fullName()"></a>
                                            <div class="friend-offer_tx">предлагает вам дружбу!</div>
                                        </div>
                                        <div class="friend-offer_btns"><a class="btn-green-simple btn-s" data-bind="click: user.friendsAccept">Принять</a><a title="Отклонить" class="ico-cancel powertip" data-bind="click: user.friendsDecline">&#8211;</a></div>
                                    </div>
                                </div>
                                <!-- /ko --> */ ?>
                                <!-- im_loader есть всегда, на разные действия в нем менятеся содержимое-->
                                <div class="im_loader">
                                    <!-- ko if: sendingMessage -->
                                    <img src="/new/images/ico/ajax-loader.gif" alt="" class="im_loader-img"><span class="im_loader-tx">Отправляем сообщение</span>
                                    <!-- /ko -->
                                    <!-- ko if: user.typing -->
                                    <span class="im_loader-tx"><span data-bind="text: user.firstName"></span> печатает вам сообщение</span><img src="/new/images/im/im-message_loader__write.png" alt="" class="im_loader-anim">
                                    <!-- /ko -->
                                    <!-- ko if: sendingMessageError -->
                                    <span class="im_loader-tx"><span class="errorMessage">Сообщение отправить не удалось. Попробуйте повторить попытку через несколько секунд.</span></span>
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
                        <div class="im-center_bottom-ava"><a class="ava ava__middle ava__female" data-bind="attr: { href : me.profileUrl }" target="_blank"><span class="ico-status ico-status__online"></span><img alt="" data-bind="attr: {src: me.avatar()}" class="ava_img"/></a>
                        </div>
                        <div class="im-center_bottom-hold">
                            <!-- По клику на input заменять на wysiwyg -->
                            <!-- ko ifnot: editing -->
                            <input type="text" placeholder="Введите ваше сообщение" class="im-center_bottom-itx" data-bind="click: setEditing" />
                            <!-- /ko -->
                            <!-- ko if: editing -->
                            <div class="redactor-control">
                                <div class="redactor-control_hold">
                                    <textarea cols="40" name="redactor" rows="1" autofocus="autofocus" class="redactor" data-bind="redactorHG: { config : editorConfig, attr : editor }"></textarea>
                                </div>
                                <div class="redactor-control_toolbar"></div>
                                <div class="redactor-control_control">
                                    <div class="redactor-control_key">
                                        <input type="checkbox" class="redactor-control_key-checkbox" data-bind="checked: $root.settings.messaging__enter(), click: function() {$root.settings.toggle('messaging__enter')}"/>
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
</div>
<?php
Yii::app()->clientScript->registerAMD('messagingVM', array('Messaging' => 'ko_messaging', 'ko' => 'knockout'), "messaging = new Messaging(" . $data . "); ko.applyBindings(messaging, document.getElementById('" . $this->id . "_messaging_module')); return messaging;");
?>
