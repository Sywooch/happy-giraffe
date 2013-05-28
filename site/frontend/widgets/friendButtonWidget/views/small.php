<span id="<?=$id?>">
    <!-- ko if: status() == 0 -->
    <a href="#login" class="add-friend fancy" data-theme="white-square"></a>
    <!-- /ko -->
    <!-- ko if: status() == 1 -->
    <span class="friend">друг</span>
    <!-- /ko -->
    <!-- ko if: status() == 2 -->
    <a class="add-friend tooltip" data-bind="click: invite" title="Пригласить в друзья"></a>
    <!-- /ko -->
    <!-- ko if: status() == 3 -->
    <a class="add-friend tooltip" title="Приглашение выслано"></a>
    <!-- /ko -->
    <!-- ko if: status() == 4 -->
    <a class="add-friend tooltip" data-bind="click: invite" title="Принять приглашение"></a>
    <!-- /ko -->
</span>

<script type="text/javascript">
    ko.applyBindings(new FriendButtonViewModel(<?=CJSON::encode($data)?>)), document.getElementById('<?=$id?>');
</script>