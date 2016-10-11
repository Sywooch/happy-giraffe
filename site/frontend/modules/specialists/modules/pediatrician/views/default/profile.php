<?php

/**
 * @var LiteController
 * @var \site\frontend\modules\specialists\models\ProfileForm $form
 */
$this->pageTitle = 'Профиль специалиста';

?>

<div class="user-setting__exit"><a href="<?=$this->createUrl('/site/logout')?>" class="user-setting__exit-link">Выход</a></div>
<pediatrician-profile-form params="<?=htmlentities(\HJSON::encode($form))?>"></pediatrician-profile-form>