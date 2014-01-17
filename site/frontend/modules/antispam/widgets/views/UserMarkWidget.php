<?php
/**
 * @var string $domId
 * @var $json
 */
?>

<div class="antispam-user-act" id="<?=$domId?>">
    <a title="В белый список" class="antispam-user-act_i antispam-user-act_i__white active powertip"></a>
    <a title="В черный список" class="antispam-user-act_i antispam-user-act_i__black powertip"></a>
    <a title="Блок" class="antispam-user-act_i antispam-user-act_i__block powertip"></a>
</div>

<script type="text/javascript">
    $(function() {
        ko.applyBindings(new UserMarkWidget(<?=CJSON::encode($json)?>), document.getElementById('<?=$domId?>'));
    });
</script>