<?php

/**
 * @var LiteController
 * @var \site\frontend\modules\specialists\models\ProfileForm $form
 */

$this->pageTitle = 'Профиль специалиста';

?>

<!--
<div class="user-setting__exit">
    <a href="<?//=$this->createUrl('/site/logout')?>" class="user-setting__exit-link">Выход</a>
</div>
-->

<div id="root"></div>

<?php

// Bundle JS
Yii::app()->clientScript->registerScriptFile('/frontend/builds/specialist.profile.bundle.js', ClientScript::POS_END);

?>