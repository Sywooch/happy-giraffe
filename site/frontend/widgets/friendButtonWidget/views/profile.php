<?php if (Yii::app()->user->isGuest): ?>
    <a href="#login" class="user-btns_i powertip fancy">
        <span class="user-btns_ico-hold user-btns_ico-hold__friend-add">
            <span class="user-btns_ico"></span>
        </span>
        <span class="user-btns_tx"></span>
    </a>
<?php else: ?>
<!-- ko stopBinding: true -->
<a href="<?=$this->user->url?>" class="user-btns_i powertip" id="<?=$id?>" data-bind="click: clickHandler">
    <span class="user-btns_ico-hold" data-bind="css: cssClass">
        <span class="user-btns_ico"></span>
    </span>
    <span class="user-btns_tx"></span>
</a>
<!-- /ko -->

<script type="text/javascript">
    ko.applyBindings(new FriendButtonViewModel(<?=CJSON::encode($data)?>), document.getElementById('<?=$id?>'));
</script>
<?php endif; ?>