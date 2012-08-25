<?php
$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($baseUrl . '/' . 'script.js', CClientScript::POS_BEGIN);

?>
<div id="block-blog">

</div>
<div id="block-club">

</div>
<div id="block-comments">

</div>

<div id="block-posts">

</div>

<div id="block-additionalPosts">

</div>