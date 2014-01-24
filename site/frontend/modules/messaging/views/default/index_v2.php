<div class="layout-wrapper_hold clearfix">
    <div class="im" style="display: none" data-bind="attr: { 'style': '' }">
        <!-- js для расчетов положения почты -->
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
                    self.container.height(h);
                }
                self.renew = function() {
                    self.windowHeight = $(window).height();
                    imHeight();
                    containerHeight();
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
                        self.headerHeight = $('.header').height();
                        self.renew();
                    }
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
                            <a href="" class="side-menu_i" data-bind="click: function() {setFilter(0);}, css: {active: currentFilter() == 0}">
                                <span class="side-menu_i-hold">
                                    <span class="side-menu_ico side-menu_ico__all"></span>
                                    <span class="side-menu_tx">Все</span>
                                </span>
                                <span class="verticalalign-m-help"></span>
                            </a>
                            <a href="" class="side-menu_i" data-bind="click: function() {setFilter(1);}, css: {active: currentFilter() == 1}">
                                <span class="side-menu_i-hold">
                                    <span class="side-menu_ico side-menu_ico__new"></span>
                                    <span class="side-menu_tx">Новые</span>
                                    <span class="side-menu_count" data-bind="text: countTotal"></span>
                                </span>
                                <span class="verticalalign-m-help"></span>
                            </a>
                            <a href="" class="side-menu_i" data-bind="click: function() {setFilter(2);}, css: {active: currentFilter() == 2}">
                                <span class="side-menu_i-hold">
                                    <span class="side-menu_ico side-menu_ico__online"></span>
                                    <span class="side-menu_tx">Кто онлайн</span>
                                </span>
                                <span class="verticalalign-m-help"></span>
                            </a>
                            <a href="" class="side-menu_i" data-bind="click: function() {setFilter(3);}, css: {active: currentFilter() == 3}">
                                <span class="side-menu_i-hold">
                                    <span class="side-menu_ico side-menu_ico__online-friend"></span>
                                    <span class="side-menu_tx">Друзья онлайн</span>
                                </span>
                                <span class="verticalalign-m-help"></span>
                            </a>
                        </div>
                    </div>
                    <!-- /side-menu-->
                    <div class="im-sidebar_sound"><a class="im-sidebar_sound-ico" data-bind="click: function() {settings.toggle('messaging__sound')}, css: { inactive : ! settings.messaging__sound() }"></a></div>
                </div>
                <div class="im-sidebar_users">
                    <div class="im-sidebar_search clearfix">
                        <input type="text" name="" placeholder="Поиск диалогов" data-bind="value: search, valueUpdate: 'keyup'" class="im-sidebar_search-itx"/>
                        <button class="im-sidebar_search-btn" data-bind="click: clearSearch"></button>
                    </div>
                    <!-- im-user-list-->
                    <div class="im-user-list">
                        <div data-bind="css: {scroll: true}">
                            <div class="scroll_scroller" data-bind="show: {selector: '.im-user-list_i:visible:gt(-20)', callback: loadContacts}">
                                <div class="scroll_cont" data-bind="foreach: getContactList">
                                    <div class="im-user-list_i clearfix" data-bind="visible: isShow, click: open, css: { active: isActive }">
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
                                            <button class="btn-green" data-bind="click: deleteDialog">Да</button>
                                            <button class="btn-gray-light">Нет</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                        </div>
                        <div class="im-panel_user clearfix">
                            <a href="" class="ava ava__middle ava__female"><span class="ico-status ico-status__online" data-bind="visible: user.isOnline()"></span><img alt="" data-bind="attr: {src: user.avatar}" class="ava_img"/></a>
                            <div class="im-panel_user-status" data-bind="visible: !user.isOnline()"><span data-bind="text: user.gender ? 'Был на сайте' : 'Была на сайте'"></span> <span data-bind="moment: {value: user.lastOnline(), timeAgo: true}"></span></div>
                            <div class="im-panel_user-name" data-bind="text: user.fullName()"></div>
                            <!-- У иконки 3 состояния.
                            Друг - без моидфикатора
                            Добавить в друзья - .friend__add
                            Приглашение отправленно - .friend__added
                            -->
                            <a class="im-panel_friend im-panel_friend__fr" data-bind="click: user.friendsHandler, if: user.friendsState() == user.FRIENDS_STATE_FRIENDS"><span class="im-panel_friend-ico"></span><span class="im-panel_friend-tx">Друг</span></a>
                            <a class="im-panel_friend im-panel_friend__add" data-bind="click: user.friendsHandler, if: user.friendsState() == user.FRIENDS_STATE_NOTHING || user.friendsState() == user.FRIENDS_STATE_INCOMING"><span class="im-panel_friend-ico"></span><span class="im-panel_friend-tx">Добавить <br> в друзья</span></a>
                            <a class="im-panel_friend im-panel_friend__added" data-bind="click: user.friendsHandler, if: user.friendsState() == user.FRIENDS_STATE_OUTGOING"><span class="im-panel_friend-ico"></span><span class="im-panel_friend-tx">Приглашение <br> отправлено</span></a>
                        </div>
                    </div>
                    <!-- /im-panel-->
                </div>
                <div class="im-center_middle">
                    <div data-bind="css: {scroll: true}">
                        <div class="im-center_middle-hold scroll_scroller">
                            <div class="im-center_middle-w scroll_cont" data-bind="show: {selector: '>.im-message:visible:lt(2)', callback: loadMessages}">
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
                                    <div class="im-message" data-bind="visible: !hidden(), show: show, hide: hide, css: {'im-message__new': !isMy && !dtimeRead(), 'im-message__edited': $parent.editingMessage() == $data}">
                                        <div class="im-message_ava"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online" data-bind="visible: from.isOnline()"></span><img alt="" data-bind="attr: {src: from.avatar}" class="ava_img"/></a>
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
                                                        <div class="b-control_i tooltip-click-b" data-bind="css: {'display-n' : isMy}">
                                                            <span class="b-control_ico powertip b-control_ico__spam" href="" data-tooltip="Пожаловаться" title="Пожаловаться"></span>
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
                                                <span class="im-message_t-read" data-bind="visible: isMy && dtimeRead() && $parent.lastReadMessage() == $data">Сообщение прочитано</span>
                                                <span class="im-message_t-read-no" data-bind="visible: isMy && !dtimeRead() && !cancelled()">Сообщение не прочитано</span>
                                            </div>
                                            <div class="im-message_tx" data-bind="visible: !dtimeDelete() && !cancelled(), html: text"></div>
                                            <div class="im-message_tx color-gray" data-bind="visible: dtimeDelete()">Сообщение удалено. <a href="#" class="font-s" data-bind="click: restore">Восстановить</a></div>
                                            <div class="im-message_tx color-gray-light" data-bind="visible: cancelled()">Сообщение отменено.</div>
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
                                <textarea cols="40" name="redactor" rows="1" autofocus="autofocus" class="redactor" data-bind="redactorHG: editorConfig"></textarea>
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
</div>
<script type="text/javascript">
	$(function() {
        messaging = new Messaging(<?=$data?>);
		ko.applyBindings(messaging, document.getElementById(<?=$this->id?>_messaging_module));
	});
</script>