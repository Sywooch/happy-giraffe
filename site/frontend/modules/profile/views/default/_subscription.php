<?php
$json = array(
    'id' => $user->id,
    'active' => UserBlogSubscription::isSubscribed(Yii::app()->user->id, $user->id),
);

?>
<div class="clearfix margin-20" id="blog-subscription">
    <?php if (!Yii::app()->user->isGuest && Yii::app()->user->id != $user->id): ?>
        <a href="" class="btn-green btn-medium float-r" data-bind="visible: !active(), click: toggle">Подписаться</a>
        <a href="" class="btn-medium float-r btn-lightgray" data-bind="visible: active(), click: toggle">Отписаться</a>
    <?php endif ?>

    <h3 class="heading-small float-l margin-t5">Моя активность</h3>
</div>
<script type="text/javascript">
    $(function() {
        var vm = new ProfileBlogSubscription(<?=CJSON::encode($json)?>);
        ko.applyBindings(vm, document.getElementById('blog-subscription'));
    });
</script>
