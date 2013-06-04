<span id="<?=$id?>">
    <!-- ko if: status() == 0 -->
    <a href="#login" class="add-friend fancy" data-theme="white-square"><i class="icon"></i>Пригласить<br/>в друзья</a>
    <!-- /ko -->
    <!-- ko if: status() == 1 -->
    <span class="is-friend">мой друг</span>
    <!-- /ko -->
    <!-- ko if: status() == 2 -->
    <a class="add-friend" data-bind="click: invite"><i class="icon"></i>Пригласить<br/>в друзья</a>
    <!-- /ko -->
    <!-- ko if: status() == 3 -->
    <a class="add-friend request-sent"><i class="icon"></i>Приглашение<br/>уже выслано</a>
    <!-- /ko -->
    <!-- ko if: status() == 4 -->
    <a class="add-friend" data-bind="click: accept"><i class="icon"></i>Принять<br/>приглашение</a>
    <!-- /ko -->
</span>

<script type="text/javascript">
    ko.applyBindings(new FriendButtonViewModel(<?=CJSON::encode($data)?>), document.getElementById('<?=$id?>'));
</script>