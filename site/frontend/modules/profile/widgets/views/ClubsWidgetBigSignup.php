<?php
/**
 * @var $this ClubsWidget
 */
?>
<div class="club-list club-list__big margin-l20 clearfix" id="user-clubs-<?=$this->uniqid?>">
    <ul class="club-list_ul clearfix">
        <!-- ko foreach: SingupClubs -->
        <li class="club-list_li" data-bind="css: {'club-list_li__in': have()}">
            <a href="" class="club-list_i" data-bind="click: toggle">
                <span class="club-list_img-hold">
                    <img src="" class="club-list_img" data-bind="attr: {src: src}">
                    <span class="club-list_img-overlay"></span>
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
        ko.applyBindings(vm, document.getElementById('user-clubs-<?=$this->uniqid?>'));
    });
</script>