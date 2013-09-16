<?php
Yii::app()->controller->widget('site.common.extensions.imperavi-redactor-widget.ImperaviRedactorWidget', array('onlyRegisterScript' => true));
?>

<div class="im" data-bind="css: { im__cap : me.avatar() === false }">
    <div class="im_hold clearfix">
        <div class="im-sidebar">
            <h2 class="im-sidebar_t">Мои диалоги</h2>
            <div class="im-sidebar_search clearfix">
                <input type="text" class="im-sidebar_search-itx" placeholder="Найти по имени" data-bind="value: searchQuery, valueUpdate: 'keyup'">
                <button class="im-sidebar_search-btn" data-bind="click: clearSearchQuery, css: { active : searchQuery() != '' }"></button>
            </div>
            <div class="im-user-list">
                <!-- ko template: { name: 'contact-template', foreach: contactsToShow } --><!-- /ko -->
            </div>
            <a class="im-sidebar_hide-a" data-bind="click: toggleShowHiddenContacts, css: { active : showHiddenContacts }">
                <span class="a-checkbox"></span>
                <span class="im-sidebar_hide-a-tx">Показать скрытые</span>
            </a>
        </div>
        <div class="im-center">

            <div class="im-center_top">
                <div class="im-tabs">
                    <a href="javascript:void(0)" class="im_sound" data-bind="click: toggleSoundSetting, css: { active : soundSetting }, tooltip: soundSetting() ? 'Выключить звуковые <br>оповещения' : 'Включить звуковые <br>оповещения'"></a>
                    <div class="im-tabs_i" data-bind="css: { active : tab() == 0 }"><a href="javascript:void(0)" class="im-tabs_a" data-bind="click: function(data, event) { changeTab(0, data, event) }">Все</a></div>
                    <div class="im-tabs_i" data-bind="css: { active : tab() == 1 }"><a href="javascript:void(0)" class="im-tabs_a" data-bind="css: { inactive : newContactsCount() == 0 }, click: function(data, event) { if (newContactsCount() > 0) changeTab(1, data, event) }">Новые <span class="im_count" data-bind="visible: newContactsCount() > 0, text: newContactsCount()"></span> </a></div>
                    <div class="im-tabs_i" data-bind="css: { active : tab() == 2 }"><a href="javascript:void(0)" class="im-tabs_a" data-bind="css: { inactive : onlineContactsCount() == 0 }, click: function(data, event) { if (onlineContactsCount() > 0) changeTab(2, data, event) }, text: onlineContactsCount() > 0 ? 'Кто в онлайн (' + onlineContactsCount() + ')' : 'Кто в онлайн'"></a></div>
                    <div class="im-tabs_i" data-bind="css: { active : tab() == 3 }"><a href="javascript:void(0)" class="im-tabs_a" data-bind="css: { inactive : friendsContactsCount() == 0 }, click: function(data, event) { if (friendsContactsCount() > 0) changeTab(3, data, event) }, text: friendsContactsCount() > 0 ? 'Друзья на сайте (' + friendsContactsCount() + ')' : 'Друзья на сайте'"></a></div>
                </div>
                <div class="im-panel" data-bind="if: interlocutor() !== null">
                    <div class="im-panel-icons">
                        <div class="im-panel-icons_i">
                            <!-- ko if: ! interlocutor().user().isFriend() && ! interlocutor().inviteSent() -->
                            <a class="im-panel-icons_i-a powertip" title="Добавить в друзья" data-bind="click: addFriend">
                                <span class="im-panel-ico im-panel-ico__add-friend"></span>
                                <span class="im-panel-icons_desc">Добавить <br>в друзья </span>
                            </a>
                            <!-- /ko -->
                            <!-- ko if: interlocutor().inviteSent() -->
                            <span class="im-panel-icons_i-a powertip im-panel-icons_i-a__request" title="Добавить в друзья">
                                <span class="im-panel-ico im-panel-ico__added-friend"></span>
                                <span class="im-panel-icons_desc">Запрос <br> отправлен</span>
                            </span>
                            <!-- /ko -->
                            <!-- ko if: interlocutor().user().isFriend() -->
                            <span class="im-panel-icons_i-a powertip im-panel-icons_i-a__friend" title="Друг">
                                <span class="im-panel-ico im-panel-ico__friend"></span>
                                <span class="im-panel-icons_desc">Друг</span>
                            </span>
                            <!-- /ko -->
                        </div>
                        <div class="im-panel-icons_i" data-bind="css: { active : interlocutor().toBlackList() }">
                            <a class="im-panel-icons_i-a powertip" title="Заблокировать пользователя" data-bind="click: interlocutor().blockHandler">
                                <span class="im-panel-ico im-panel-ico__blacklist"></span>
                                <span class="im-panel-icons_desc">В черный <br> список</span>
                            </a>
                            <div class="im-tooltip-popup">
                                <div class="im-tooltip-popup_t">Вы уверены?</div>
                                <p class="im-tooltip-popup_tx">Пользователь из черного списка не сможет писать вам личные сообщения и комментировать ваши записи</p>
                                <label for="im-tooltip-popup_checkbox" class="im-tooltip-popup_label-small clearfix">
                                    <input type="checkbox" name="" id="im-tooltip-popup_checkbox" class="im-tooltip-popup_checkbox" data-bind="checked: blackListSetting">
                                    Больше не показывать данное предупреждение
                                </label>
                                <div class="clearfix textalign-c">
                                    <button class="btn-green" data-bind="click: interlocutor().yesHandler">Да</button>
                                    <button class="btn-gray-light" data-bind="click: interlocutor().noHandler">Нет</button>
                                </div>
                            </div>
                        </div>
                        <div class="im-panel-icons_i" data-bind="if: openContact() !== null && openContact().thread() !== null && messagesToShow().length > 0">
                            <a class="im-panel-icons_i-a powertip" title="Удалить диалог" data-bind="click: openContact().thread().deleteMessages">
                                <span class="im-panel-ico im-panel-ico__del"></span>
                                <span class="im-panel-icons_desc">Удалить <br> диалог</span>
                            </a>
                        </div>
                    </div>
                    <div class="im-user-settings clearfix">
                        <a class="ava middle" data-bind="css: interlocutor().user().avatarClass(), attr : { href : '/user/' + interlocutor().user().id() + '/' }">
                            <span class="icon-status status-online" data-bind="visible: interlocutor().user().online()"></span>
                            <img alt="" data-bind="attr : { src : interlocutor().user().avatar() }">
                        </a>
                        <div class="im-user-settings_user">
                            <a class="textdec-onhover" data-bind="attr : { href : '/user/' + interlocutor().user().id() + '/' }, text: interlocutor().user().fullName()"></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="im-center_middle" data-bind="visible: openContact() !== null">
                <div class="im-center_middle-hold">

                    <div class="im-center_middle-w" data-bind="if: interlocutor() !== null && ! interlocutor().isBlocked()">
                        <div class="im_message-loader" data-bind="visible: loadingMessages()">
                            <img src="/images/ico/ajax-loader.gif" alt="">
                            <span class="im-message-loader_tx">Загрузка ранних сообщений</span>
                        </div>

                        <!-- ko template: { name: 'message-template', foreach: messages } -->

                        <!-- /ko -->

                        <div class="im_message-loader" data-bind="visible: sendingMessage()">
                            <img src="/images/ico/ajax-loader.gif" alt="">
                            <span class="im-message-loader_tx">Отправляем сообщение</span>
                        </div>
                        <div class="im_message-loader" data-bind="if: interlocutor() != '', visible: interlocutorTyping()">
                            <span class="im-message-loader_tx" data-bind="text: interlocutor().user().firstName() + ' печатает вам сообщение'"></span>
                            <img src="/images/im/im_message-write-loader.png" alt="" class="im_message-loader-anim">
                        </div>
                        <div class="im_message-loader" data-bind="visible: editingMessageId() !== null">
                            Вы можете  <a href="javascript:void(0)" data-bind="click: $root.cancelMessage">Отменить</a>  данное сообщение или отредактировать его ниже
                        </div>
                    </div>
                    <!-- ko if: interlocutor() !== null && interlocutor().isBlocked() -->
                    <div class="cap-empty">
                        <div class="cap-empty_hold">
                            <div class="cap-empty_tx">Этот пользователь вас заблокировал!</div>
                            <span class="cap-empty_gray">Вы не можете отправлять ему сообщения</span>
                        </div>
                    </div>
                    <!-- /ko -->
                </div>
            </div>
            <div class="im-center_bottom" data-bind="visible: openContact() !== null">
                <div class="im-center_bottom-hold">

                    <div class="im-editor-b">
                        <a href="javascript:void(0)" class="ava small im-editor-b_ava" data-bind="css: me.avatarClass()">
                            <img alt="" data-bind="attr : { src : me.avatar() }" />
                        </a>
                        <div class="im-editor-b_w redactor-control-b wysiwyg-blue">
                            <textarea cols="40" id="redactor" name="redactor" class="redactor" rows="1" autofocus></textarea>
                            <div class="redactor-control-b_toolbar"></div>
                            <div class="redactor-control-b_control">
                                <div class="redactor-control-b_key">
                                    <input type="checkbox" name="" id="redactor-control-b_key-checkbox" class="redactor-control-b_key-checkbox" data-bind="checked: enterSetting, click: focusEditor">
                                    <label for="redactor-control-b_key-checkbox" class="redactor-control-b_key-label">Enter - отправить</label>
                                </div>
                                <button class="btn-green" data-bind="click: submit, text: editingMessageId() === null ? 'Отправить' : 'Сохранить'">Отправить</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="im-cap" data-bind="visible: me.avatar() === false">
                <div class="im-cap_hold">
                    <div class="im-cap_t">У вас есть непрочитанные сообщения!</div>
                    <div class="im-cap_tx">Для того чтобы начать пользоваться сервисом, <br>необходимо загрузить главное фото</div>
                    <div class="clearfix">
                        <div class="file-fake">
                            <button class="file-fake_btn btn-green btn-medium">Загрузить фото</button>
                            <input type="file" />
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
$this->widget('site.frontend.widgets.photoView.photoViewWidget', array(
    'registerScripts' => true,
));
?>

<div style="display: none;">
    <div class="upload-btn">
        <?php
        $fileAttach = $this->beginWidget('application.widgets.fileAttach.FileAttachWidget', array(
            'entity' => 'MessagingMessage',
        ));
        $fileAttach->button();
        $this->endWidget();
        ?>
    </div>
</div>

<script type="text/html" id="contact-template">
    <div class="im-user-list_i clearfix" data-bind="click: $root.openThread, css: { active : user().id() == $root.openContactInterlocutorId() }">
        <div class="im-user-settings">
            <a class="ava small" data-bind="css: user().avatarClass">
                <span class="icon-status status-online" data-bind="visible: user().online()"></span>
                <img alt="" data-bind="attr: { src: user().avatar }">
            </a>
            <div class="im-user-settings_user">
                <a data-bind="text: user().fullName()"></a>
            </div>
        </div>
        <!-- ko if: thread() !== null -->
        <div class="im_watch" data-bind="click: thread().toggleHiddenStatus, clickBubble: false, tooltip: thread().hideButtonTitle"></div>
        <div class="im_count" data-bind="click: thread().toggleReadStatus, clickBubble: false, text: thread().unreadCount(), css: { 'im_count__read' : thread().isRead() }, tooltip: thread().readButtonTitle"></div>
        <!-- /ko -->
    </div>
</script>

<script type="text/html" id="message-template">
    <div class="im-message clearfix" data-bind="visible: deleted() === false, css: { 'im-message__edited' : edited }">

        <div class="b-control-abs" data-bind="css: { 'b-control-abs__self' : author().id() == $root.me.id(), active : showAbuse() }">
            <div class="b-control-abs_hold">
                <!-- ko if: author().id() == $root.me.id() && ! read() -->
                <div class="clearfix">
                    <a class="message-ico message-ico__edit" data-bind="click: $data.edit, tooltip: 'Редактировать'"></a>
                </div>
                <!-- /ko -->
                <div class="clearfix">
                    <a class="message-ico message-ico__del" data-bind="click: $data.delete, tooltip: 'Удалить'"></a>
                </div>
            </div>
            <!-- ko if: author().id() != $root.me.id() -->
            <div class="position-rel clearfix">
                <a class="message-ico message-ico__warning" data-bind="click: toggleShowAbuse, tooltip: 'Пожаловаться'"></a>

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
                        <button class="btn-green" data-bind="click: markAsSpam">Пожаловаться</button>
                        <button class="btn-gray-light" data-bind="click: toggleShowAbuse">Отменить</button>
                    </div>
                </div>
            </div>
            <!-- /ko -->
        </div>

        <a class="ava small" href="javascript:void(0)" data-bind="css: author().avatarClass()">
            <img alt="" data-bind="attr : { src : author().avatar() }">
        </a>
        <div class="im-message_hold">
            <div class="im-message_t">
                <a href="javascript:void(0)" class="im-message_user" data-bind="text: author().firstName()"></a>
                <em class="im-message_date" data-bind="text: created()"></em>
                <div class="im-message_status" data-bind="visible: ($root.me.id() == author().id() && (! read() || $data == $root.lastReadMessage())), css: read() ? 'im-message_status__read' : 'im-message_status__noread', text: read() ? 'Сообщение прочитано' : 'Сообщение не прочитано'"></div>
            </div>
            <div class="im-message_tx" data-bind="html: text()"></div>
        </div>
    </div>
    <div class="im-message clearfix" data-bind="visible: deleted() === true">
        <a class="ava small" href="javascript:void(0)" data-bind="css: author().avatarClass()">
            <img alt="" data-bind="attr : { src : author().avatar() }">
        </a>
        <div class="im-message_hold">
            <div class="im-message_t">
                <a href="javascript: void(0)" class="im-message_user" data-bind="text: author().firstName()"></a>
                <em class="im-message_date" data-bind="text: created()"></em>
            </div>
            <div class="im-message_tx">
                <span data-bind="text: isSpam() ? 'Это сообщение помечено как спам и удалено.' : 'Это сообщение удалено.'"></span> <a href="javascript:void(0)" data-bind="click: restore">Восстановить</a>
            </div>
        </div>
    </div>
</script>

<script type="text/html" id="message-old-template">
    <div class="im-message clearfix" data-bind="visible: deleted() === false, css: { 'im-message__edited' : edited }">
        <div class="im-message_icons" data-bind="css: { active : showAbuse() }">
            <div class="im-message_icons-i" data-bind="if: author().id() != $root.me.id(), css: { active : showAbuse() }">
                <a href="javascript:void(0)" class="im-message_ico im-message_ico__warning im-tooltipsy" data-bind="click: toggleShowAbuse, tooltip: 'Пожаловаться'"></a>

                <div class="im-tooltip-popup">
                    <div class="im-tooltip-popup_t">Укажите вид нарушения:</div>
                    <label for="im-tooltip-popup_radio" class="im-tooltip-popup_label clearfix">
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
                        <input type="text" name="" id="" class="im-tooltip-popup_itx" placeholder="Другое">
                    </label>
                    <div class="clearfix textalign-c">
                        <button class="btn-green" data-bind="click: markAsSpam">Пожаловаться</button>
                        <button class="btn-gray" data-bind="click: toggleShowAbuse">Отменить</button>
                    </div>
                </div>
            </div>
            <div class="im-message_icons-i">
                <a href="javascript:void(0)" class="im-message_ico im-message_ico__del im-tooltipsy" data-bind="click: $data.delete, tooltip: 'Удалить'"></a>
            </div>
        </div>
        <a class="ava small" href="javascript:void(0)" data-bind="css: author().avatarClass()">
            <img alt="" data-bind="attr : { src : author().avatar() }">
        </a>
        <div class="im-message_hold">
            <div class="im-message_t">
                <a href="javascript: void(0)" class="im-message_user" data-bind="text: author().firstName()"></a>
                <em class="im-message_date" data-bind="text: created()"></em>
                <div class="im-message_status" data-bind="visible: ($root.me.id() == author().id() && (! read() || $data == $root.lastReadMessage())), css: read() ? 'im-message_status__read' : 'im-message_status__noread', text: read() ? 'Сообщение прочитано' : 'Сообщение не прочитано'"></div>
                <a href="javascript:void(0)" class="im-message_ico im-message_ico__edit im-tooltipsy" data-bind="visible: $root.me.id() == author().id() && ! read(), tooltip: 'Редактировать', click: $data.edit"></a>
            </div>
            <div class="im-message_tx" data-bind="html: text()">

            </div>
            <div class="im-message_tx-img clearfix" data-bind="foreach: images, gallery: id()">
                <a href="javascript:void(0)" class="im-message_img" data-bind="attr: { 'data-id' : id() }">
                    <img alt="" data-bind="attr: { src : preview }">
                </a>
            </div>
        </div>
    </div>
    <div class="im-message clearfix" data-bind="visible: deleted() === true">
        <a class="ava small" href="javascript:void(0)" data-bind="css: author().avatarClass()">
            <img alt="" data-bind="attr : { src : author().avatar() }">
        </a>
        <div class="im-message_hold">
            <div class="im-message_t">
                <a href="javascript: void(0)" class="im-message_user" data-bind="text: author().firstName()"></a>
                <em class="im-message_date" data-bind="text: created()"></em>
            </div>
            <div class="im-message_tx">
                <span data-bind="text: isSpam() ? 'Это сообщение помечено как спам и удалено.' : 'Это сообщение удалено.'"></span> <a href="javascript:void(0)" data-bind="click: restore">Восстановить</a>
            </div>
        </div>
    </div>
</script>

<script type="text/javascript">
    $(function() {
        ko.bindingHandlers.gallery = {
            init: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext) {
                $(element).find('a').pGallery({'singlePhoto':false,'entity':'MessagingMessage','entity_id':valueAccessor(),'entity_url':null});
            },
            update: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext) {
                $(element).find('a').pGallery({'singlePhoto':false,'entity':'MessagingMessage','entity_id':valueAccessor(),'entity_url':null});
            }
        };

        ko.bindingHandlers.mirror = {
            init: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext) {
                $(element).hide();
                $('#cke_uploadedImages').html($(element).html());
            },
            update: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext) {
                $('#cke_uploadedImages').html($(element).html());
            }
        };


        vm = new MessagingViewModel(<?=$data?>);
        ko.applyBindings(vm);
    });
</script>