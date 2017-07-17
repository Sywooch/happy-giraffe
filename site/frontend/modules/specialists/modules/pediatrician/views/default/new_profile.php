<?php

/**
 * @var LiteController
 * @var \site\frontend\modules\specialists\models\ProfileForm $form
 */

$this->pageTitle = 'Профиль специалиста';

?>


<div id="root"></div>

<?php Yii::app()->clientScript->registerScriptFile('/frontend/builds/specialist.profile.bundle.js', ClientScript::POS_END); ?>