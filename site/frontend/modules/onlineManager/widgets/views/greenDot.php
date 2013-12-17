<?php
/* @var $this OnlineManagerWidget */
/* @var $user User */
$jsonUser = CJSON::encode(OnlineManagerWidget::userToJson($user));
$blockId = $this->id . '_' . $user->id;
?>
<div class="onlineDot" id="<?=$blockId?>" data-bind="css: {green : user().online}">.</div>
<script type="text/javascript">
	$(function(){
		ko.applyBindings(new OnlineManager(<?=$jsonUser?>, '<?=$user->publicChannel?>'), document.getElementById('<?=$blockId?>'));
	});
</script>