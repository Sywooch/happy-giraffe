<?php
$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($baseUrl . '/' . 'script.js', CClientScript::POS_BEGIN);

?>
<div id="blog-posts">

</div>
<div id="club-posts">

</div>
<div id="comments">

</div>

<div id="posts">

</div>

<div id="additional_posts">

</div>