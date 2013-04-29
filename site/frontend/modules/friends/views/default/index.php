<?php
    Yii::app()->clientScript
        ->registerScriptFile('/javascripts/knockout-2.2.1.js')
        ->registerScriptFile('/javascripts/ko_friends.js')
    ;
?>

<div class="content-cols">
    <div class="col-1">
        <h2 class="col-1_t">Мои друзья
            <div class="col-1_sub-t"><a href="<?=$this->createUrl('/friends/default/search')?>" class="">Найти друзей</a></div>
        </h2>

        <div class="col-1_search clearfix">
            <input type="text" class="col-1_search-itx" placeholder="Введите имя или фамилию" data-bind="value: searchQuery, valueUpdate: 'keyup'">
            <button class="col-1_search-btn" data-bind="css: { active : searchQuery() != '' }, click: clearSearchQuery"></button>
        </div>
        <div class="menu-list">
            <a href="javascript:void(0)" class="menu-list_i" data-bind="click: selectAll, css: { active : selectedListId() === null && activeTab() == 0 }">
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

        <div class="cont-nav" data-bind="visible: selectedListId() == null">
            <div class="cont-nav_i" data-bind="css: { active : activeTab() == 0 }">
                <a href="javascript:void(0)" class="cont-nav_a" data-bind="css: { inactive : friendsCount() == 0 }, text: friendsCount() > 0 ? 'Все (' + friendsCount() + ')' : 'Все', click: function(data, event) { selectTab(0, data, event) }"></a>
            </div>
            <div class="cont-nav_i" data-bind="css: { active : activeTab() == 1 }">
                <span class="user-online-status"></span>
                <a href="javascript:void(0)" class="cont-nav_a" data-bind="css: { inactive : friendsOnlineCount() == 0 }, text: friendsOnlineCount() > 0 ? 'На сайте (' + friendsOnlineCount() + ')' : 'На сайте', click: function(data, event) { selectTab(1, data, event) }"></a>
            </div>
            <div class="cont-nav_i" data-bind="css: { active : activeTab() == 2 }">
                <a href="javascript:void(0)" class="cont-nav_a" data-bind="css: { inactive : incomingRequestsCount() == 0 }, click: function(data, event) { selectTab(2, data, event) }">Хотят дружить<span class="cont-nav_count" data-bind="visible: incomingRequestsCount() > 0, text: incomingRequestsCount"></span> </a>
            </div>
        </div>

        <div class="friends-list">
            <div class="friends-list_i">
                <a href="<?=$this->createUrl('/friends/default/search')?>" class="friends-list_find"></a>
            </div>
            <!-- ko if: $root.activeTab() != 2 -->
                <!-- ko foreach: friendsToShow -->
                <div class="friends-list_i">
                    <!-- ko template: { name: 'user-template', data: user() } --><!-- /ko -->
                    <div class="friends-list_group">
                        <a href="javascript:void(0)" class="friends-list_group-a powertip" title="Изменить список" onclick="$(this).next().toggle()" data-bind="visible: $root.lists().length > 0, text: listLabel"></a>
                        <div class="friends-list_group-popup">
                            <a href="javascript:void(0)" class="friends-list_group-popup-a" onclick="$(this).parent().hide()" data-bind="click: unbindList, visible: listId() !== null">Все друзья</a>
                            <!-- ko foreach: $root.lists -->
                            <a href="javascript:void(0)" class="friends-list_group-popup-a" onclick="$(this).parent().hide()" data-bind="text: title, click: $parent.bindList, visible: $parent.listId() != id()"></a>
                            <!-- /ko -->
                        </div>
                    </div>
                </div>
                <!-- /ko -->
            <!-- /ko -->

            <!-- ko if: $root.activeTab() == 2 -->
                <!-- ko foreach: friendsRequests -->
                <div class="friends-list_i">
                    <!-- ko template: { name: 'user-template', data: user() } --><!-- /ko -->
                    <div class="friends-list_group">
                        <a href="javascript:void(0)" class="btn-green btn-middle" data-bind="click: accept">Принять</a>
                        <a href="javascript:void(0)" class="btn-gray-light btn-middle" data-bind="click: decline">Отклонить</a>
                    </div>
                </div>
                <!-- /ko -->
            <!-- /ko -->

            <div id="infscr-loading" data-bind="visible: loading"><img src="/images/ico/ajax-loader.gif" alt="Loading..."><div>Загрузка</div></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    ko.bindingHandlers.tooltip = {
        init: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext) {
            $(element).data('powertip', valueAccessor());
        },
        update: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext) {
            $(element).data('powertip', valueAccessor());
            $(element).powerTip({
                placement: 'n',
                smartPlacement: true,
                popupId: 'tooltipsy-im',
                offset: 8
            });
        }
    };

    $(function() {
        vm = new FriendsViewModel(<?=$data?>);
        ko.applyBindings(vm);
    });
</script>

<script type="text/html" id="user-template">
    <div class="friends-list_ava-hold clearfix">
        <a class="ava large" data-bind="attr: { href : url }">
            <img data-bind="attr: { src : ava }" alt="">
        </a>
        <span class="friends-list_online" data-bind="visible: online">На сайте</span>
        <!-- ko if: $root.activeTab() != 2 -->
        <a href="javascript:void(0)" class="ico-close2 friends-list_close powertip" data-bind="click: $parent.remove, tooltip: 'Удалить из друзей'"></a>
        <!-- /ko -->
        <a class="friends-list_bubble friends-list_bubble__dialog powertip" data-bind="attr: { href : dialogUrl }, tooltip: 'Начать диалог'">
            <span class="friends-list_ico friends-list_ico__mail"></span>
            <!--<span class="friends-list_bubble-tx">+5</span>-->
        </a>
        <a class="friends-list_bubble friends-list_bubble__photo powertip" data-bind="attr: { href : albumsUrl }, tooltip: 'Фотографии'">
            <span class="friends-list_ico friends-list_ico__photo"></span>
            <!--<span class="friends-list_bubble-tx">+50</span>-->
        </a>
        <a class="friends-list_bubble friends-list_bubble__blog powertip" data-bind="attr: { href : blogUrl }, tooltip: 'Записи в блоге'">
            <span class="friends-list_ico friends-list_ico__blog"></span>
            <!--<span class="friends-list_bubble-tx">+999</span>-->
        </a>
    </div>
    <a href="javascript:void(0)" class="friends-list_a" data-bind="text: fullName"></a>
</script>