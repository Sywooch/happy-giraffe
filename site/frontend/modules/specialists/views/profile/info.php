<?php
/**
 * @var LiteController $this
 * @var \site\frontend\modules\specialists\models\SpecialistProfile $profile
 */

$this->pageTitle = $this->user->getFullName() . ' на Веселом Жирафе';
$this->metaNoindex = true;
$profile = $this->user->specialistProfile;

?>

<?php $this->renderPartial('_userSection', ['user' => $this->user]); ?>

<div class="landing-question">
    <div class="user-settings form-edit">
        <?php if ($profile->specialization): ?>
            <div class="user-settings_hold"><span class="heading-sm">Специализация</span></div>
            <div class="user-settings_hold">
                <div class="form-edit_tx"><?=$profile->specialization?></div>
            </div>
        <?php endif; ?>
        <?php if ($profile->career): ?>
            <div class="user-settings_hold"><span class="heading-sm">Опыт работы</span></div>
            <?php $this->renderPartial('_infoTable', ['models' => $profile->career]); ?>
        <?php endif; ?>
        <?php if ($profile->education): ?>
            <div class="user-settings_hold"><span class="heading-sm">Образование</span></div>
            <?php $this->renderPartial('_infoTable', ['models' => $profile->education]); ?>
        <?php endif; ?>
        <?php if ($profile->coursesObject->models): ?>
            <div class="user-settings_hold"><span class="heading-sm">Курсы повышения квалификации</span></div>
            <?php $this->renderPartial('_infoTable', ['models' => $profile->coursesObject->models]); ?>
        <?php endif; ?>
    </div>
</div>
