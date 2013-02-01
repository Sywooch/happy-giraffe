<?php
/**
 * Author: alexk984
 * Date: 01.02.13
 *
 * @var $route Route
 */

$js = 'Routes.init("'.$route->cityFrom->getFullName().'", "'.$route->cityTo->getFullName().'");';

$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);

Yii::app()->clientScript
    ->registerScriptFile('http://maps.googleapis.com/maps/api/js?libraries=places&key=' . Yii::app()->params['google_map_key'] . '&sensor=true')
    ->registerCoreScript('jquery.ui')
    ->registerScript('routes_module', $js)
    ->registerScriptFile($baseUrl . '/routes.js');

?>
<h2><?=$route->cityFrom->name . ' ' . $route->cityTo->name ?></h2>
<div id="map_canvas" style="width:900px; height:400px;"></div>
