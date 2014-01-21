<?php
/**
 * @var MarkWidget $this
 * @var $json
 * @var $domId
 */
?>


<div class="antispam_control" id="<?=$domId?>">
    <!-- ko with: check() -->
        <!-- ko if: ! isMarked() -->
            <div class="margin-b5 clearfix">
                <a class="btn-green btn-m" data-bind="click: function() {mark(<?=AntispamCheck::STATUS_GOOD?>)}"><div class="ico-btn-check"></div>Хорошо</a>
            </div>
            <?php if ($this->analysisMode): ?>
                <div class="margin-b5 clearfix">
                    <a class="btn-red btn-m" data-bind="click: function() {mark(<?=AntispamCheck::STATUS_BAD?>)}"><div class="ico-btn-del"></div>Удалить</a>
                </div>
            <?php else: ?>
                <div class="margin-b5 clearfix">
                    <a class="btn-red btn-m" href="<?=Yii::app()->controller->createUrl('/antispam/default/analysis', array('userId' => $this->check->user_id, 'entity' => AntispamCheck::getSpamEntity($this->check->entity)))?>"><div class="ico-btn-empty"></div>Анализ</a>
                </div>
                <div class="margin-b5 clearfix"><a class="btn-gray-light btn-s" data-bind="click: function() {mark(<?=AntispamCheck::STATUS_QUESTIONABLE?>)}">Под ?</a></div>
            <?php endif; ?>
        <!-- /ko -->
        <!-- ko if: isMarked -->
            <div class="margin-b5 clearfix">
                <a title="Изменить решение" class="margin-r5 powertip" data-bind="css: iconClass(), click: function() {mark(<?=AntispamCheck::STATUS_UNDEFINED?>)}"></a>
                <!-- ko with: moderator() -->
                <a class="ava powertip ava__small" data-bind="attr: { title : fullName, href : url }">
                    <span class="ico-status" data-bind="css: iconClass"></span>
                    <img alt="" class="ava_img" data-bind="attr: { src : ava }, visible: ava !== false" />
                </a>
                <!-- /ko -->
            </div>
            <div class="color-gray font-sx" data-bind="text: updated"></div>
        <!-- /ko -->
    <!-- /ko -->
</div>

<script type="text/javascript">
    $(function() {
        ko.applyBindings(new MarkWidget(<?=CJSON::encode($json)?>), document.getElementById('<?=$domId?>'));
    });
</script>

