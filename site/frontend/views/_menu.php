<?php
Yii::app()->clientScript->registerPackage('ko_menu');
$user = Yii::app()->user->model;
?>

<div class="layout-header clearfix">
    <?php $this->renderPartial('//_menu_fix'); ?>
    <?php $this->renderPartial('//_menu_base'); ?>
</div>

<script type="text/javascript">
    menuVm = new MenuViewModel(<?=CJSON::encode($this->menuData)?>);
    ko.applyBindings(menuVm, $('.header-fix')[0]);
    ko.applyBindings(menuVm, $('.header')[0]);
</script>