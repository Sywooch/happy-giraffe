<?php
/**
 * @var $this ClubsWidget
 */
?>
<div class="club-list margin-t20 clearfix" id="user-clubs">
    <div class="clearfix textalign-c">
        <span class="heading-medium">Выбери свой клуб </span>
    </div>
    <ul class="club-list_ul clearfix">
        <!-- ko foreach: clubs -->
        <li class="club-list_li" data-bind="css: {'club-list_li__in': have()}">
            <a href="" class="club-list_i" data-bind="attr: {href: url}">
                <span class="club-list_img-hold">
                    <img src="" class="club-list_img" data-bind="attr: {src: src}">
                </span>
                <span class="club-list_i-name" data-bind="text: title"></span>
            </a>
            <?php if (Yii::app()->user->isGuest):?>
                <a href="#login" class="club-list_check powertip" data-bind="tooltip: tooltipText"></a>
            <?php else: ?>
                <a href="" class="club-list_check powertip" data-bind="click: toggle, tooltip: tooltipText"></a>
            <?php endif ?>
        </li>
        <!-- /ko -->
    </ul>
</div>
<script type="text/javascript">
    $(function () {
        vm = new UserClubsWidget(<?=CJSON::encode($this->data)?>, <?=CJSON::encode($this->getParams()) ?>);
        ko.applyBindings(vm, document.getElementById('user-clubs'));
    });
</script>