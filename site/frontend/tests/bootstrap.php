<?php
require_once('/opt/yii/framework/yii.php');
new TestApplication();
YiiBase::setPathOfAlias('site', '/home/giraffe/happy-giraffe.ru/site');
Yii::app()->setAliases(array(
    'Guzzle' => 'site.common.vendor.Guzzle',
    'Symfony' => 'site.common.vendor.Symfony',
));
