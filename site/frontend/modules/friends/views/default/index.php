<?php
Yii::app()->clientScript
    ->registerScriptFile('/javascripts/knockout-2.2.1.js')
    ->registerScriptFile('/javascripts/ko_friends.js?t=' . time())
;
?>

<div class="content-cols">
    <div class="col-1">
        <div class="b-ava-large">
            <div class="b-ava-large_ava-hold clearfix">
                <a class="ava large female" href="">
                </a>
                <span class="b-ava-large_online">На сайте</span>
                <a href="" class="b-ava-large_bubble b-ava-large_bubble__dialog powertip" title="Начать диалог">
                    <span class="b-ava-large_ico b-ava-large_ico__mail"></span>
                    <span class="b-ava-large_bubble-tx">+5</span>
                </a>
                <a href="" class="b-ava-large_bubble b-ava-large_bubble__photo powertip" title="Фотографии">
                    <span class="b-ava-large_ico b-ava-large_ico__photo"></span>
                    <span class="b-ava-large_bubble-tx">+50</span>
                </a>
                <a href="" class="b-ava-large_bubble b-ava-large_bubble__blog powertip" title="Записи в блоге">
                    <span class="b-ava-large_ico b-ava-large_ico__blog"></span>
                    <span class="b-ava-large_bubble-tx">+999</span>
                </a>
            </div>
            <div class="textalign-c">
                <a href="" class="b-ava-large_a">Александр Богоявленский</a>
            </div>
        </div>

        <div class="menu-list">
            <a class="menu-list_i active" data-bind="click: selectAll, css: { active : selectedListId() === null && activeTab() == 0 && newSelected() === false }">
                <span class="menu-list_tx">Все друзья</span>
                <span class="menu-list_count" data-bind="text: friendsCount"></span>
            </a>
            <a class="menu-list_i" data-bind="visible: friendsNewCount() > 0, click: selectNew, css: { active : newSelected }">
                <span class="menu-list_tx">Новые</span>
                <span class="menu-list_count" data-bind="text: friendsNewCount"></span>
            </a>
            <!-- ko foreach: lists -->
            <a class="menu-list_i" data-bind="click: select, css: { active : $root.selectedListId() == id() }">
                <span class="menu-list_tx" data-bind="text: title"></span>
                <span class="menu-list_count" data-bind="text: friendsCount"></span>
                <span class="ico-close" data-bind="click: remove, clickBubble: false, visible: friendsCount() == 0"></span>
            </a>
            <!-- /ko -->
            <div class="menu-list_row">
                <a href="javascript:void(0)" class="menu-list_a textdec-none" onclick="$('#addList').hide(); $('#addListForm').show();" id="addList">
                    <span class="ico-plus2"></span>
                    <span class="a-pseudo-gray color-gray">Создать новый список</span>
                </a>
                <div class="menu-list_i-add" style="display: none;" id="addListForm">
                    <input type="text" class="menu-list_i-add-itx" placeholder="Название списка" data-bind="value: newListTitle, valueUpdate: 'keyup', event: { keypress : addListHandler }">
                    <button class="ico-plus2" data-bind="click: addList"></button>
                </div>
            </div>
            <div class="menu-list_row margin-t20">
                <a href="" class="btn-green btn-medium margin-b5">Найти новых друзей</a>
                <div class="color-gray" data-bind="visible: outgoingRequestsCount() > 0, text: 'Отправлено приглашений - ' + outgoingRequestsCount()"></div>
            </div>
        </div>
    </div>

    <div class="col-23-middle clearfix">
        <div class="heading-title clearfix">
            <div class="sidebar-search sidebar-search__gray float-r">
                <input type="text" placeholder="Введите имя или фамилию" class="sidebar-search_itx" data-bind="value: searchQuery, valueUpdate: 'keyup'">
                <button class="sidebar-search_btn" data-bind="css: { active : searchQuery() != '' }, click: clearSearchQuery"></button>
            </div>
            Мои друзья
        </div>

        <div class="col-gray clearfix">
        <div class="cont-nav" data-bind="visible: selectedListId() == null">
            <div class="cont-nav_i" data-bind="css: { active : activeTab() == 0 }">
                <a class="cont-nav_a" data-bind="css: { inactive : friendsCount() == 0 }, text: friendsCount() > 0 ? 'Все (' + friendsCount() + ')' : 'Все', click: function(data, event) { if (friendsCount() > 0) selectTab(0, data, event) }"></a>
            </div>
            <div class="cont-nav_i" data-bind="css: { active : activeTab() == 1 }">
                <span class="user-online-status"></span>
                <a class="cont-nav_a" data-bind="css: { inactive : friendsOnlineCount() == 0 }, text: friendsOnlineCount() > 0 ? 'На сайте (' + friendsOnlineCount() + ')' : 'На сайте', click: function(data, event) { if (friendsOnlineCount() > 0) selectTab(1, data, event) }"></a>
            </div>
            <div class="cont-nav_i" data-bind="css: { active : activeTab() == 2 }">
                <a class="cont-nav_a" data-bind="css: { inactive : incomingRequestsCount() == 0 }, click: function(data, event) { if (incomingRequestsCount() > 0) selectTab(2, data, event) }">Хотят дружить<span class="cont-nav_count" data-bind="visible: incomingRequestsCount() > 0, text: incomingRequestsCount"></span> </a>
            </div>
            <div class="cont-nav_i" data-bind="css: { active : activeTab() == 3 }">
                <a href="" class="cont-nav_a">Мои приглашения (20) </a>
            </div>
        </div>
        <div class="friends-list" data-bind="css: { 'friends-list__family' : activeTab() >= 2 }">
            <!-- ko if: activeTab() <= 1 -->
            <div class="friends-list_i">
                <a href="<?=$this->createUrl('/friends/search/index')?>" class="friends-list_find"></a>
            </div>
            <!-- /ko -->

            <!-- ko template: { name : templateName, foreach : templateForeach } -->

            <!-- /ko -->


            <div id="infscr-loading" data-bind="visible: loading"><img src="/images/ico/ajax-loader.gif" alt="Loading..."><div>Загрузка</div></div>
        </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        vm = new FriendsViewModel(<?=$data?>);
        ko.applyBindings(vm);
    });
</script>

<script type="text/html" id="user-template">
<div class="friends-list_i">
    <div class="b-ava-large" data-bind="with: user">
        <div class="b-ava-large_ava-hold clearfix">
            <a class="ava large" data-bind="attr: { href : url }, css: avaClass">
                <img alt="" data-bind="visible: ava, attr: { src : ava }">
            </a>
            <span class="b-ava-large_online" data-bind="visible: online">На сайте</span>
            <a class="ico-close2 b-ava-large_close" data-bind="click: $parent.remove, tooltip: 'Удалить из друзей'"></a>
            <a class="b-ava-large_bubble b-ava-large_bubble__dialog" data-bind="attr: { href : dialogUrl }, tooltip: 'Начать диалог'">
                <span class="b-ava-large_ico b-ava-large_ico__mail"></span>
                <!--<span class="b-ava-large_bubble-tx">+5</span>-->
            </a>
            <a class="b-ava-large_bubble b-ava-large_bubble__photo" data-bind="attr: { href : albumsUrl }, tooltip: 'Фотографии'">
                <span class="b-ava-large_ico b-ava-large_ico__photo"></span>
                <!--<span class="b-ava-large_bubble-tx">+50</span>-->
            </a>
            <a class="b-ava-large_bubble b-ava-large_bubble__blog" data-bind="attr: { href : blogUrl }, tooltip: 'Записи в блоге'">
                <span class="b-ava-large_ico b-ava-large_ico__blog"></span>
                <!--<span class="b-ava-large_bubble-tx">+999</span>-->
            </a>
            <span class="b-ava-large_bubble b-ava-large_bubble__friend">
                <span class="b-ava-large_ico b-ava-large_ico__friend"></span>
                <span class="b-ava-large_bubble-tx">друг</span>
            </span>
        </div>
        <div class="textalign-c">
            <a class="b-ava-large_a" data-bind="text: fullName, attr: { href : url }"></a>
        </div>
    </div>

    <div class="friends-list_group">
        <a class="friends-list_group-a" onclick="$(this).next().toggle()" data-bind="visible: $root.lists().length > 0, text: listLabel, tooltip: 'Изменить список'"></a>
        <div class="friends-list_group-popup">
            <a class="friends-list_group-popup-a" onclick="$(this).parent().hide()" data-bind="click: unbindList, visible: listId() !== null">Все друзья</a>
            <!-- ko foreach: $root.lists -->
            <a class="friends-list_group-popup-a" onclick="$(this).parent().hide()" data-bind="text: title, click: $parent.bindList, visible: $parent.listId() != id()"></a>
            <!-- /ko -->
        </div>
    </div>

    <div class="friends-list_deleted" data-bind="visible: removed">
        <div class="friends-list_deleted-hold">
            <a class="friends-list_a" data-bind="text: user().fullName, attr: { href : user().url }"></a>
            <div class="friends-list_row color-gray">удалена из списка <br>ваших друзей</div>
            <a class="a-pseudo" data-bind="click: restore">Восстановить?</a>
        </div>
    </div>
</div>
</script>

<script type="text/html" id="request-template">
<div class="friends-list_i">
    <div class="b-ava-large" data-bind="with: user">
        <div class="b-ava-large_ava-hold clearfix">
            <a class="ava large" data-bind="attr: { href : url }, css: avaClass">
                <img alt="" data-bind="visible: ava, attr: { src : ava }">
            </a>
            <span class="b-ava-large_online" data-bind="visible: online">На сайте</span>
            <a class="b-ava-large_bubble b-ava-large_bubble__dialog" data-bind="attr: { href : dialogUrl }, tooltip: 'Начать диалог'">
                <span class="b-ava-large_ico b-ava-large_ico__mail"></span>
                <!--<span class="b-ava-large_bubble-tx">+5</span>-->
            </a>
            <a class="b-ava-large_bubble b-ava-large_bubble__photo" data-bind="attr: { href : albumsUrl }, tooltip: 'Фотографии'">
                <span class="b-ava-large_ico b-ava-large_ico__photo"></span>
                <!--<span class="b-ava-large_bubble-tx">+50</span>-->
            </a>
            <a class="b-ava-large_bubble b-ava-large_bubble__blog" data-bind="attr: { href : blogUrl }, tooltip: 'Записи в блоге'">
                <span class="b-ava-large_ico b-ava-large_ico__blog"></span>
                <!--<span class="b-ava-large_bubble-tx">+999</span>-->
            </a>
            <span class="b-ava-large_bubble b-ava-large_bubble__friend">
                <span class="b-ava-large_ico b-ava-large_ico__friend"></span>
                <a class="b-ava-large_plus" data-bind="click: $parent.accept, tooltip: 'Принять'"></a>
                <a class="b-ava-large_minus" data-bind="click: $parent.decline, tooltip: 'Отказаться'"></a>
            </span>
        </div>
        <div class="textalign-c">
            <a class="b-ava-large_a" data-bind="text: fullName, attr: { href : url }"></a>
            <!-- ko if: age !== null -->
            <span class="font-smallest color-gray" data-bind="text: age"></span>
            <!-- /ko -->
        </div>
    </div>
    <!-- ko if: user().location !== null -->
    <div class="friends-list_location clearfix" data-bind="html: user().location"></div>
    <!-- /ko -->
    <!-- ko if: user().family !== null -->
    <div class="find-friend-famyli" data-bind="html: user().family"></div>
    <!-- /ko -->
    <!-- ko if: removed -->
    <div class="cap-empty">
        <div class="cap-empty_hold">
            <div class="cap-empty_tx">Вы отклонили <br> предложение</div>
            <span class="cap-empty_gray">Пользователь успешно <br> удален из этого списка</span>
            <div class="clearfix">
                <a class="a-pseudo" data-bind="click: restore">Восстановить?</a>
            </div>
        </div>
    </div>
    <!-- /ko -->
</div>
</script>