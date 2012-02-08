<div id="vk_like"></div>
<?php
$js = "$('#vk_like').html(VK.Share.button(" . CJavaScript::encode($this->options) . ", {type: 'round'}));";

Yii::app()->clientScript
    ->registerScriptFile('http://vk.com/js/api/share.js', CClientScript::POS_HEAD)
    ->registerScript('vk_share', $js, CClientScript::POS_END)
?>