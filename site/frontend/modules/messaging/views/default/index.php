<div class="im">
    <div class="im_hold clearfix">
        <div class="im-sidebar">
            <h2 class="im-sidebar_t">Мои диалоги</h2>
            <div class="im-sidebar_search clearfix">
                <input type="text" class="im-sidebar_search-itx" placeholder="Найти по имени" data-bind="value: searchQuery, valueUpdate: 'keyup'">
                <button class="im-sidebar_search-btn"></button>
            </div>
            <div class="im-user-list">
                <!-- ko template: { name: 'contact-template', foreach: visibleContactsToShow } -->

                <!-- /ko -->
                <a href="javascript:void(0)" class="im-user-list_hide-a" data-bind="visible: hiddenContactsToShow().length > 0">Показать скрытые</a>
                <div class="im-user-list_hide-b" data-bind="template: { name: 'contact-template', foreach: hiddenContactsToShow }">

                </div>
            </div>
        </div>
        <div class="im-center">

            <div class="im-center_top">
                <div class="im-tabs">
                    <a href="javascript:void(0)" class="im_sound im-tooltipsy" title="Включить звуковые <br>оповещения" data-bind="click: toggleSoundSetting, css: { active : soundSetting }"></a>
                    <div class="im-tabs_i" data-bind="css: { active : tab() == 0 }"><a href="javascript:void(0)" class="im-tabs_a" data-bind="click: function(data, event) { changeTab(0, data, event) }">Все</a></div>
                    <div class="im-tabs_i" data-bind="css: { active : tab() == 1 }"><a href="javascript:void(0)" class="im-tabs_a" data-bind="click: function(data, event) { changeTab(1, data, event) }">Новые <span class="im_count" data-bind="visible: newContacts().length > 0, text: newContacts().length"></span> </a></div>
                    <div class="im-tabs_i" data-bind="css: { active : tab() == 2 }"><a href="javascript:void(0)" class="im-tabs_a" data-bind="click: function(data, event) { changeTab(2, data, event) }, text: 'Кто в онлайн (' + onlineContacts().length + ')'"></a></div>
                    <div class="im-tabs_i" data-bind="css: { active : tab() == 3 }"><a href="javascript:void(0)" class="im-tabs_a" data-bind="click: function(data, event) { changeTab(3, data, event) }, text: 'Друзья на сайте (' + friendsContacts().length + ')'"></a></div>
                </div>
                <div class="im-panel" data-bind="if: interlocutor() != '', css: { 'im-panel__big' : interlocutorExpandedSetting }">
                    <div class="im-panel-icons">
                        <div class="im-panel-icons_i">
                            <a href="javascript:void(0)" class="im-panel-icons_i-a im-tooltipsy" title="Добавить в друзья" data-bind="click: addFriend, visible: (! interlocutor().user.isFriend() && ! interlocutor().inviteSent())">
                                <span class="im-panel-ico im-panel-ico__add-friend"></span>
                                <span class="im-panel-icons_desc">Добавить <br> в друзья</span>
                            </a>
                        </div>
                        <div class="im-panel-icons_i">
                            <a href="javascript:void(0)" class="im-panel-icons_i-a  im-tooltipsy" title="Заблокировать пользователя" data-bind="click: block">
                                <span class="im-panel-ico im-panel-ico__blacklist"></span>
                                <span class="im-panel-icons_desc">Заблокировать <br> пользователя</span>
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
                                    <button class="btn-gray">Нет</button>
                                </div>
                            </div>
                        </div>
                        <div class="im-panel-icons_i" data-bind="if: openContact().thread() !== null">
                            <a href="javascript:void(0)" class="im-panel-icons_i-a im-tooltipsy" title="Удалить весь диалог" data-bind="click: openContact().thread().deleteMessages">
                                <span class="im-panel-ico im-panel-ico__del"></span>
                                <span class="im-panel-icons_desc">Удалить <br> весь диалог</span>
                            </a>
                        </div>
                    </div>
                    <div class="im-user-settings clearfix">
                        <div class="im-user-settings_online-status-small"></div>
                        <a class="ava" data-bind="css: interlocutor().user.avatarClass(), attr : { href : '/user/' + interlocutor().user.id() + '/' }">
                            <img alt="" data-bind="attr : { src : interlocutor().user.avatar() }">
                        </a>
                        <div class="im-user-settings_user">
                            <a class="textdec-onhover" data-bind="attr : { href : '/user/' + interlocutor().user.id() + '/' }, text: interlocutor().user.fullName()"></a>
                            <div class="im-user-settings_online-status" data-bind="visible: interlocutor().user.online()">На сайте</div>
                        </div>
                        <div class="user-fast-buttons">
                            <a href="javascript:void(0)" data-bind="attr : { href : '/user/' + interlocutor().user.id() + '/' }">Анкета</a>
                            <a href="javascript:void(0)" data-bind="visible: interlocutor().blogPostsCount() > 0, attr : { href : '/user/' + interlocutor().user.id() + '/blog/' }">Блог</a><sup class="count" data-bind="visible: interlocutor().blogPostsCount() > 0, text: interlocutor().blogPostsCount()"></sup>
                            <a href="javascript:void(0)" data-bind="visible: interlocutor().photosCount() > 0, attr : { href : '/user/' + interlocutor().user.id() + '/albums/' }">Фото</a><sup class="count" data-bind="visible: interlocutor().photosCount() > 0, text: interlocutor().photosCount()"></sup>
                        </div>
                    </div>
                    <span class="im_toggle" data-bind="click: toggleinterlocutorExpandedSetting"></span>
                </div>
            </div>

            <div class="im-center_middle" data-bind="visible: openContact() !== null">
                <div class="im-center_middle-hold">

                    <div class="im-center_middle-w">
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
                            <span class="im-message-loader_tx" data-bind="text: interlocutor().user.firstName() + ' печатает вам сообщение'"></span>
                            <img src="/images/im/im_message-write-loader.png" alt="" class="im_message-loader-anim">
                        </div>
                        <div class="im_message-loader" data-bind="visible: false">
                            Вы можете  <a href="">Отменить</a>  данное сообщение или отредактировать его ниже
                        </div>
                    </div>
                </div>
            </div>
            <div class="im-center_bottom" data-bind="visible: openContact() !== null">
                <div class="im-center_bottom-hold">

                    <div class="im-editor-b">
                        <a href="javascript:void(0)" class="ava small im-editor-b_ava" data-bind="css: me.avatarClass()">
                            <img alt="" data-bind="attr : { src : me.avatar() }" />
                        </a>
                        <div class="im-editor-b_w">
                            <textarea cols="40" id="im-editor" name="im-editor" rows="3" autofocus></textarea>
                            <div class="im-editor-b_control">
                                <div class="im-editor-b_key">
                                    <input type="checkbox" name="" id="im-editor-b_key-checkbox" class="im-editor-b_key-checkbox" data-bind="checked: enterSetting">
                                    <label for="im-editor-b_key-checkbox" class="im-editor-b_key-label">Enter - отправить</label>
                                </div>
                                <button class="btn-green" data-bind="click: sendMessage">Отправить</button>
                            </div>
                        </div>
                        <span class="im_toggle"></span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div style="display: none;">
    <div class="upload-btn">
        <?php
        $fileAttach = $this->beginWidget('application.widgets.fileAttach.FileAttachWidget', array(
            'entity' => 'BlogContent',
        ));
        $fileAttach->button();
        $this->endWidget();
        ?>
    </div>
</div>

<script type="text/html" id="contact-template">
    <div class="im-user-list_i" data-bind="click: $root.openThread, css: { active : $root.contacts().indexOf($data) == $root.openContactIndex() }">
        <div class="im-user-settings clearfix">
            <div class="im-user-settings_online-status-small" data-bind="css: { 'im-user-settings_online-status-small__offline' : ! user().online() }"></div>
            <a class="ava female" href="">
                <img alt="" data-bind="attr: { src: user().avatar }">
            </a>
            <div class="im-user-settings_user">
                <a data-bind="text: user().fullName()"></a>
            </div>
        </div>
        <!-- ko if: thread() !== null -->
        <div class="im_watch im-tooltipsy" title="Скрыть диалог" data-bind="click: thread().toggleHiddenStatus, clickBubble: false"></div>
        <div class="im_count im-tooltipsy" title="Отметить как прочитанное" data-bind="click: thread().toggleReadStatus, clickBubble: false, text: thread().unreadCount(), css: { 'im_count__read' : thread().unreadCount() == 0 }"></div>
        <!-- /ko -->
    </div>
</script>

<script type="text/html" id="message-template">
    <div class="im-message clearfix">
        <div class="im-message_icons" data-bind="css: { active : showAbuse() }">
            <div class="im-message_icons-i" data-bind="if: author().id() != $root.me.id(), css: { active : showAbuse() }">
                <a href="javascript:void(0)" class="im-message_ico im-message_ico__warning im-tooltipsy" title="Пожаловаться" data-bind="click: toggleShowAbuse"></a>

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
                        <button class="btn-green" data-bind="click: toggleShowAbuse">Пожаловаться</button>
                        <button class="btn-gray" data-bind="click: toggleShowAbuse">Отменить</button>
                    </div>
                </div>
            </div>
            <div class="im-message_icons-i">
                <a href="javascript:void(0)" class="im-message_ico im-message_ico__del im-tooltipsy" title="Удалить" data-bind="click: $data.delete"></a>
            </div>
        </div>
        <a class="ava small" href="javascript:void(0)" data-bind="css: author().avatarClass()">
            <img alt="" data-bind="attr : { src : author().avatar() }">
        </a>
        <div class="im-message_hold">
            <div class="im-message_t">
                <a href="javascript: void(0)" class="im-message_user" data-bind="text: author().firstName()"></a>
                <em class="im-message_date" data-bind="text: created()"></em>
                <div class="im-message_status" data-bind="visible: ($root.me.id() == author().id() && (! read() || $data.id() == $root.lastReadMessage().id())), css: read() ? 'im-message_status__read' : 'im-message_status__noread', text: read() ? 'Сообщение прочитано' : 'Сообщение не прочитано'"></div>
            </div>
            <div class="im-message_tx" data-bind="html: text()">

            </div>
        </div>
    </div>
</script>

<script type="text/javascript">
    $(function() {
        ko.applyBindings(new MessagingViewModel(<?=$data?>));
    });

    //<![CDATA[

    $(function(){

        /* skin hgru-comment */
        CKEDITOR.replace( 'im-editor',
            {
                /* autofocus */
                on :
                {
                    instanceReady : function( ev )
                    {
                        this.focus();
                    }
                },

                contentsCss : '/ckeditor/skins/im-editor/contents.css',
                skin : 'im-editor',
                toolbar : [
                    ['othertext', 'Smiles','Attach']
                ],
                toolbarCanCollapse: false,
                disableObjectResizing: false,
                resize_enabled : false,
                toolbarLocation : 'bottom',
                height: 58
            });

    });

    //]]>
</script>