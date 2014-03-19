<?php
/**
 * @var $this ClubsWidget
 */
?>

<ul class="club-list_ul clearfix" id="user-clubs-<?=$this->uniqid?>" style="display: none" data-bind="visible: true">
    <!-- ko foreach: clubs -->
    <li class="club-list_li" data-bind="css: {'club-list_li__in': have()}">
        <a class="club-list_i" data-bind="click: toggle">
            <span class="club-list_img-hold"><img alt="" class="club-list_img" data-bind="attr: { src : src }"><span class="club-list_img-overlay"></span></span><span class="club-list_i-name" data-bind="text: title"></span>
        </a>
    </li>
    <!-- /ko -->
</ul>
<script type="text/javascript">
    $(function () {
        vm = new UserClubsWidget(<?=CJSON::encode($this->data)?>, <?=CJSON::encode($this->getParams()) ?>);
        ko.applyBindings(vm, document.getElementById('user-clubs-<?=$this->uniqid?>'));
    });
</script>