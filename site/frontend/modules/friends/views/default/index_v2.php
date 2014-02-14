<?php Yii::app()->clientScript->registerPackage('ko_friends'); ?>
<?php $this->pageTitle = 'Мои друзья'; ?>
<div class="layout-wrapper_frame clearfix">
    <?php $this->renderPartial('friends.views._menu'); ?>
    <div class="page-col page-col__friend">
        <div class="page-col_hold">
            <div class="page-col_top" data-bind="visible: activeTab() < 2">
                <div class="sidebar-search clearfix">
                    <input type="text" name="" placeholder="Введите имя и/или фамилию" class="sidebar-search_itx" data-bind="value: instantaneousQuery, valueUpdate: 'keyup'"/>
                    <!-- При начале ввода добавить класс .active на кнопку-->
                    <button class="sidebar-search_btn" data-bind="click: clearSearchQuery, css: { active : query() != '' }" ></button>
                </div>
                <div class="page-col_t">Все друзья <span data-bind="text: friendsCount"></span></div>
            </div>
            <div class="page-col_top page-col_top__gray" data-bind="visible: activeTab() > 1">
                <ul class="page-col_tabs">
                    <li class="page-col_tab" data-bind="css: { active : activeTab() == 2 }"><a class="page-col_tab-a" data-bind="click: function(data, event) { if (incomingRequestsCount() > 0) selectTab(2, data, event) }, text: 'Хотят дружить ' + incomingRequestsCount()"></a></li>
                    <li class="page-col_tab" data-bind="css: { active : activeTab() == 3 }"><a class="page-col_tab-a" data-bind="click: function(data, event) { if (outgoingRequestsCount() > 0) selectTab(3, data, event) }, text: 'Я хочу дружить ' + outgoingRequestsCount()"></a></li>
                </ul>
            </div>
            <div class="page-col_cont">
                <!-- ko if: ! (templateForeach().length == 0 && loading() === false) -->
                <div class="friends-list">
                    <div class="friends-list_ul">
                        <!-- ko template: { name : templateName, foreach : templateForeach } -->
                        <!-- /ko -->
                    </div>
                </div>
                <!-- /ko -->
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        vm = new FriendsViewModel(<?= $data ?>);
        ko.applyBindings(vm);
    });
</script>

<?php $this->renderPartial('/_userCard'); ?>
<?php $this->renderPartial('/_userRequestCard'); ?>