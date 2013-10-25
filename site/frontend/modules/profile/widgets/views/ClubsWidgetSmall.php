<?php
/**
 * @var $this ClubsWidget
 */
?>
<div class="club-list clearfix" id="user-clubs" style="display: none" data-bind="visible: true">
    <div class="clearfix">
        <span class="heading-small">Мои клубы <span class="color-gray">(<!-- ko text: count --><!-- /ko -->)</span> </span>
    </div>
    <ul class="club-list_ul clearfix">
        <?php if ($this->isMyProfile): ?>
            <li class="club-list_li">
                <a href="<?=Yii::app()->createUrl('/myGiraffe/default/recommends') ?>" class="club-list_add"></a>
            </li>
        <?php endif ?>

        <!-- ko foreach: clubs -->
        <li class="club-list_li" data-bind="css: {'club-list_li__in': have()}">
            <a href="" class="club-list_i" data-bind="attr: {href: url}">
                <span class="club-list_img-hold">
                    <img src="" class="club-list_img" data-bind="attr: {src: src}">
                </span>
                <span class="club-list_i-name" data-bind="text: title"></span>
            </a>
            <a href="" class="club-list_check powertip" data-bind="click: toggle, tooltip: tooltipText"></a>
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