<?php
Yii::app()->clientScript->registerPackage('ko_menu');
$user = Yii::app()->user->model;
?>

<!-- ko stopBinding: true -->
<div class="layout-header clearfix">
    <?php $this->renderPartial('//_menu_fix'); ?>
    <?php $this->renderPartial('//_menu_base'); ?>
</div>
<!-- /ko -->

<script type="text/javascript">
    menuVm = new MenuViewModel(<?=CJSON::encode($this->menuData)?>);
    ko.applyBindings(menuVm, $('.layout-header')[0]);
</script>