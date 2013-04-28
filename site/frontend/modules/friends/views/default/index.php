<?php
    Yii::app()->clientScript
        ->registerScriptFile('/javascripts/knockout-2.2.1.js')
        ->registerScriptFile('/javascripts/ko_friends.js')
    ;
?>

<div class="content-cols">
    <div class="col-1">
        <h2 class="col-1_t">Мои друзья
            <div class="col-1_sub-t"><a href="" class="">Найти друзей</a></div>
        </h2>

        <div class="col-1_search clearfix">
            <input type="text" class="col-1_search-itx" placeholder="Введите имя или фамилию" data-bind="value: searchQuery, valueUpdate: 'keyup'">
            <button class="col-1_search-btn" data-bind="css: { active : searchQuery() != '' }, click: clearSearchQuery"></button>
        </div>
        <div class="menu-list">
            <a href="javascript:void(0)" class="menu-list_i" data-bind="click: selectAll, css: { active : selectedListId() === null }">
                <span class="menu-list_tx">Все друзья</span>
                <span class="menu-list_count" data-bind="text: friendsCount"></span>
            </a>
            <!-- ko foreach: lists -->
            <a href="javascript:void(0)" class="menu-list_i" data-bind="click: select, css: { active : $root.selectedListId() == id() }">
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
            <div class="menu-list_row" data-bind="visible: outgoingRequestsCount() > 0">
                <div class="color-gray margin-t20" data-bind="text: 'Отправлено ' + outgoingRequestsCount() + ' ' + declOfNum(outgoingRequestsCount(), ['приглашение', 'приглашения', 'приглашений'])"></div>
            </div>
        </div>
    </div>

    <div class="col-23 clearfix">

        <div class="cont-nav">
            <div class="cont-nav_i" data-bind="css: { active : activeTab() == 0 }">
                <a href="javascript:void(0)" class="cont-nav_a" data-bind="text: 'Все (' + friendsCount() + ')', click: function(data, event) { selectTab(0, data, event) }"></a>
            </div>
            <div class="cont-nav_i" data-bind="css: { active : activeTab() == 1 }">
                <span class="user-online-status"></span>
                <a href="javascript:void(0)" class="cont-nav_a" data-bind="text: 'На сайте (' + friendsOnlineCount() + ')', click: function(data, event) { selectTab(1, data, event) }"></a>
            </div>
            <div class="cont-nav_i" data-bind="css: { active : activeTab() == 2 }">
                <a href="javascript:void(0)" class="cont-nav_a" data-bind="click: function(data, event) { selectTab(2, data, event) }">Хотят дружить<span class="cont-nav_count" data-bind="text: incomingRequestsCount"></span> </a>
            </div>
        </div>

        <div class="friends-list">
            <div class="friends-list_i">
                <a href="" class="friends-list_find"></a>
            </div>
            <!-- ko foreach: friendsToShow -->
            <div class="friends-list_i">
                <div class="friends-list_ava-hold clearfix">
                    <a href="" class="ava large">
                        <img src="/images/example/ava-large.jpg" alt="">
                    </a>
                    <span class="friends-list_online" data-bind="visible: user().online">На сайте</span>
                    <a href="javascript:void(0)" class="ico-close2 friends-list_close powertip" title="Удалить из друзей" data-bind="click: remove"></a>
                    <a href="" class="friends-list_bubble friends-list_bubble__dialog powertip" title="Начать диалог">
                        <span class="friends-list_ico friends-list_ico__mail"></span>
                        <span class="friends-list_bubble-tx">+5</span>
                    </a>
                    <a href="" class="friends-list_bubble friends-list_bubble__photo powertip" title="Фотографии">
                        <span class="friends-list_ico friends-list_ico__photo"></span>
                        <span class="friends-list_bubble-tx">+50</span>
                    </a>
                    <a href="" class="friends-list_bubble friends-list_bubble__blog powertip" title="Записи в блоге">
                        <span class="friends-list_ico friends-list_ico__blog"></span>
                        <span class="friends-list_bubble-tx">+999</span>
                    </a>
                </div>
                <a href="javascript:void(0)" class="friends-list_a" data-bind="text: user().fullName"></a>
                <div class="friends-list_group">
                    <a href="javascript:void(0)" class="friends-list_group-a powertip" title="Изменить список" onclick="$(this).next().toggle()" data-bind="text: listLabel"></a>
                    <div class="friends-list_group-popup">
                        <a href="javascript:void(0)" class="friends-list_group-popup-a" onclick="$(this).parent().hide()" data-bind="click: unbindList, visible: listId() !== null">Все друзья</a>
                        <!-- ko foreach: $root.lists -->
                        <a href="javascript:void(0)" class="friends-list_group-popup-a" onclick="$(this).parent().hide()" data-bind="text: title, click: $parent.bindList, visible: $parent.listId() != id()"></a>
                        <!-- /ko -->
                    </div>
                </div>
            </div>
            <!-- /ko -->

            <div id="infscr-loading"><img src="/images/ico/ajax-loader.gif" alt="Loading..."><div>Загрузка</div></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        vm = new FriendsViewModel(<?=$data?>);
        ko.applyBindings(vm);
    });
</script>