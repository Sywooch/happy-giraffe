<?php if (Yii::app()->user->isGuest): ?>
<a href="#login" class="b-ava-large_bubble b-ava-large_bubble__friend-add-onhover powertip fancy" title="Добавить в друзья" data-theme="transparent">
    <span class="b-ava-large_ico b-ava-large_ico__friend-add"></span>
</a>
<?php else: ?>
<!-- ko stopBinding: true -->
<a href="<?=$this->user->url?>" class="b-ava-large_bubble b-ava-large_bubble__friend-add-onhover" id="<?=$id?>" data-bind="click: clickHandler, tooltip: tip(), css: bubbleCssClass">
    <span class="b-ava-large_ico" data-bind="css: iconCssClass"></span>
</a>
<!-- /ko -->

<script type="text/javascript">
    test = new FriendButtonViewModel(<?=CJSON::encode($data)?>);
    ko.applyBindings(new FriendButtonViewModel(<?=CJSON::encode($data)?>), document.getElementById('<?=$id?>'));
</script>
<?php endif; ?>