<h1>Создать специю</h1>

<?php

$basePath = Yii::getPathOfAlias('application.views.club.cookSpices.assets');
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerCssFile($baseUrl . '/style.css', CClientScript::POS_HEAD);

echo $this->renderPartial('_form', array('model' => $model));
?>