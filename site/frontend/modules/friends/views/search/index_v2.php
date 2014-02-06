<?php Yii::app()->clientScript->registerPackage('ko_friends'); ?>
<div class="layout-wrapper_frame clearfix">
    <?php $this->renderPartial('friends.views._menu'); ?>
    <div class="page-col">
        <div class="page-col_top">
            <div class="sidebar-search clearfix">
                <input type="text" name="" placeholder="Введите имя и/или фамилию" class="sidebar-search_itx" data-bind="value: instantaneousQuery, valueUpdate: 'keyup'"/>
                <!-- При начале ввода добавить класс .active на кнопку-->
                <button class="sidebar-search_btn" data-bind="click: clearQuery, css: { active : query() != '' }" ></button>
            </div>
            <div class="page-col_t">Все друзья <?=$friendsCount?></div>
        </div>
        <div class="page-col_cont">
            <!-- ko if: ! (users().length == 0 && loading() === false) -->
            <div class="friends-list">
                <div class="friends-list_ul">
                    <!-- friend -->
                        <!-- ko template: { name : 'request-template', foreach : users } -->
                        <!-- /ko -->
                    <!-- /friend -->
                </div>
            </div>
            <!-- /ko -->
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        vm = new FriendsSearchViewModel(<?=CJSON::encode($json)?>);
        ko.applyBindings(vm);
    });
</script>

<?php $this->renderPartial('/_userCard'); ?>