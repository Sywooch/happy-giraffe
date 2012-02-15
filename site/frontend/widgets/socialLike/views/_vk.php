<div id="vk_like" style="float:right;"></div>
<?php
/*$js = "$('#vk_like').html(VK.Share.button(" . CJavaScript::encode($this->options) . ", {type: 'round'}));";

Yii::app()->clientScript
    ->registerScriptFile('http://vk.com/js/api/share.js', CClientScript::POS_HEAD)
    ->registerScript('vk_share', $js, CClientScript::POS_END)*/

Yii::app()->clientScript->registerScriptFile('http://userapi.com/js/api/openapi.js?48')
    ->registerScript('vk_init', 'VK.init({apiId: 2791084, onlyWidgets: true});', CClientScript::POS_END)
    ->registerScript('vk_like', 'VK.Widgets.Like("vk_like", {type: "button"});');
?>
