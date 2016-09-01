<?php
/**
 * @var LiteController
 * @var \site\frontend\modules\specialists\models\ProfileForm $form
 */
$this->pageTitle = 'Профиль специалиста';
?>

<pediatrician-profile-form params="<?=htmlentities(\HJSON::encode($form))?>"></pediatrician-profile-form>