<?php

/**
 * @var LiteController
 * @var \site\frontend\modules\specialists\models\ProfileForm $form
 */

$this->pageTitle = 'Персональные настройки';

?>

<div id="root"></div>

<?php Yii::app()->clientScript->registerScriptFile('/frontend/builds/specialist.settings.bundle.js', ClientScript::POS_END); ?>