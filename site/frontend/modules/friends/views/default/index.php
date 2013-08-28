<?php Yii::app()->clientScript->registerPackage('ko_friends'); ?>

<div class="content-cols">
    <div class="col-1">
        <?php $this->widget('Avatar', array('user' => Yii::app()->user->model, 'size' => 200, 'message_link' => false, 'blog_link' => false, 'location' => true, 'age' => true)); ?>

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
                <a href="<?=$this->createUrl('/friends/search/index')?>" class="btn-green btn-medium margin-b5">Найти новых друзей</a>
                <div class="color-gray" data-bind="visible: outgoingRequestsCount() > 0, text: 'Отправлено приглашений - ' + outgoingRequestsCount()"></div>
            </div>
        </div>
    </div>

    <div class="col-23-middle clearfix">
        <div class="heading-title clearfix">
            <div class="sidebar-search sidebar-search__gray float-r" data-bind="visible: activeTab() <= 1">
                <input type="text" placeholder="Введите имя или фамилию" class="sidebar-search_itx" data-bind="value: instantaneousQuery, valueUpdate: 'keyup'">
                <button class="sidebar-search_btn" data-bind="css: { active : instantaneousQuery() != '' }, click: clearSearchQuery"></button>
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
                <a class="cont-nav_a" data-bind="css: { inactive : outgoingRequestsCount() == 0 }, click: function(data, event) { if (outgoingRequestsCount() > 0) selectTab(3, data, event) }, text: 'Мои приглашения (' + outgoingRequestsCount() + ')'"></a>
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

<?php $this->renderPartial('/_requestTemplate'); ?>
<?php $this->renderPartial('/_userTemplate'); ?>

