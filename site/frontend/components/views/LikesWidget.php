<?php
$ilike = "
VK.init({
	apiId: 2450198,
	onlyWidgets: true
});
VK.Observer.subscribe('widgets.like.liked', function(count){
	rate(count);
});
VK.Observer.subscribe('widgets.like.unliked', function(count){
	rate(count);
});
	";
Yii::app()->clientScript
    ->registerScriptFile('http://vkontakte.ru/js/api/openapi.js', CClientScript::POS_HEAD)
    ->registerScript('ilike', $ilike, CClientScript::POS_HEAD)
?>
<div class="like">
    <span style="width:150px;">
        <div id="vk_like"
             style="height: 22px; width: 180px; position: relative; clear: both; background-image: none; background-attachment: initial; background-origin: initial; background-clip: initial; background-color: initial; background-position: initial initial; background-repeat: initial initial; "></div>
            <script type="text/javascript">
                VK.Widgets.Like("vk_like", {type:"button"});
            </script>
    </span>

    <div class="clear"></div>
</div>
<div class="clear"></div>