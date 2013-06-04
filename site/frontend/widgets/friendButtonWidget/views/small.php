<span id="<?=$id?>">
    <a href="#login" class="add-friend fancy tooltip" title="Пригласить в друзья" data-theme="white-square" data-bind="visible: status() == 0"></a>
    <span class="friend" data-bind="visible: status() == 1">друг</span>
    <a class="add-friend tooltip" title="Пригласить в друзья" data-bind="click: invite, visible: status() == 2"></a>
    <a class="add-friend tooltip" title="Приглашение выслано" data-bind="visible: status() == 3"></a>
    <a class="add-friend tooltip" title="Принять приглашение" data-bind="click: accept, visible: status() == 4" ></a>
</span>

<script type="text/javascript">
    ko.applyBindings(new FriendButtonViewModel(<?=CJSON::encode($data)?>), document.getElementById('<?=$id?>'));
</script>