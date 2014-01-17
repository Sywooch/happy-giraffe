<?php
/**
 * @var CWidget $this
 * @var $json
 * @var $domId
 */
?>


<div class="antispam_control" id="<?=$domId?>">
    <!-- ko if: ! check().isMarked() -->
    <div class="margin-b5 clearfix"><a class="btn-green btn-m" data-bind="click: function() {check().mark(<?=AntispamCheck::STATUS_GOOD?>)}">
            <div class="ico-btn-check"></div>Хорошо</a></div>
    <div class="margin-b5 clearfix"><a class="btn-red btn-m">
            <div class="ico-btn-empty"></div>Анализ</a></div>
    <div class="margin-b5 clearfix"><a class="btn-gray-light btn-s">Под ?</a></div>
    <!-- /ko -->
    <!-- ko if: check().isMarked -->
    <div class="margin-b5 clearfix">
        <a title="Изменить решение" class="ico-check margin-r5 powertip"></a>
        <a href="" title="Екатерина Прохожаева" class="ava powertip ava__small"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"/></a>
    </div>
    <div class="color-gray font-sx">Сегодня  23:15</div>
    <!-- /ko -->
</div>

<script>
    $(function() {
        ko.applyBindings(new MarkWidget(<?=CJSON::encode($json)?>), document.getElementById('<?=$domId?>'));
    });
</script>

