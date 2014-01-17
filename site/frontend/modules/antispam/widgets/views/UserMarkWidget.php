<?php
/**
 * @var string $domId
 * @var $json
 */
?>

<span id="<?=$domId?>">
    <!-- ko with: status -->
    <div class="antispam-user-act">
        <a title="В белый список" class="antispam-user-act_i antispam-user-act_i__white powertip" data-bind="click: function() {handle(<?=AntispamStatusManager::STATUS_WHITE?>)}, css: { active : status() == <?=AntispamStatusManager::STATUS_WHITE?> }"></a>
        <a title="В черный список" class="antispam-user-act_i antispam-user-act_i__black powertip" data-bind="click: function() {handle(<?=AntispamStatusManager::STATUS_BLACK?>)}, css: { active : status() == <?=AntispamStatusManager::STATUS_BLACK?> }"></a>
        <a title="Блок" class="antispam-user-act_i antispam-user-act_i__block powertip" data-bind="click: function() {handle(<?=AntispamStatusManager::STATUS_BLOCKED?>)}, css: { active : status() == <?=AntispamStatusManager::STATUS_BLOCKED?> }"></a>
    </div>
    <div class="antispam-user_ava">
        <!-- ko with: moderator() -->
        <a class="ava powertip ava__small" data-bind="attr: { title : fullName, href : url }">
            <span class="ico-status" data-bind="css: iconClass"></span>
            <img alt="" class="ava_img" data-bind="attr: { src : ava }, visible: ava !== false" />
        </a>
        <!-- /ko -->
    </div>
    <div class="antispam-user_date">
        <div class="color-gray" data-bind="text: updated"></div>
    </div>
    <!-- /ko -->
</span>

<script type="text/javascript">
    $(function() {
        ko.applyBindings(new UserMarkWidget(<?=CJSON::encode($json)?>), document.getElementById('<?=$domId?>'));
    });
</script>