<!-- ko stopBinding: true -->
<div class="layout-header clearfix">
    <?php $this->renderPartial('//_menu_fix'); ?>
    <?php $this->renderPartial('//_menu_base'); ?>
</div>
<!-- /ko -->
<?php
/* @var $cs ClientScript */
$cs = Yii::app()->clientScript;
if ($cs->useAMD)
{
    Yii::app()->clientScript->registerAMD('menuVM', array('ko' => 'knockout', 'MenuViewModel' => 'ko_menu'), "menuVm = new MenuViewModel(" . CJSON::encode($this->menuData) . "); ko.applyBindings(menuVm, $('.layout-header')[0]); return menuVm;");
}
else
{
    Yii::app()->clientScript->registerPackage('ko_menu');
    ?><script type="text/javascript">
        menuVm = new MenuViewModel(<?=CJSON::encode($this->menuData)?>);
        ko.applyBindings(menuVm, $('.layout-header')[0]);
    </script><?php
}
$user = Yii::app()->user->model;
?>