<?php
/**
 * @var LiteController
 * @var \site\frontend\modules\specialists\models\ProfileForm $form
 */
$this->pageTitle = 'Профиль специалиста';
?>

<pediatrician-profile-form params='<?=\HJSON::encode($form)?>'></pediatrician-profile-form>