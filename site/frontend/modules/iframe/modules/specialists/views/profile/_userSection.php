<?php
/**
 * @var User $user
 * @var \site\frontend\modules\specialists\models\SpecialistProfile $profile
 */

$profile = $user->specialistProfile;

$expCat = [];
if ($profile->experience) {
    $expCat[] = 'Стаж: ' . \site\frontend\modules\specialists\models\SpecialistProfile::getExperienceList()[$profile->experience];
}
if ($profile->category && \site\frontend\modules\specialists\models\SpecialistProfile::getCategoriesList()[$profile->category]) {
    $expCat[] = \site\frontend\modules\specialists\models\SpecialistProfile::getCategoriesList()[$profile->category];
}
?>

<section class="userSection pediator userSection-iframe">
    <div class="userSection_hold clearfix">
        <div class="userSection_left userSection-iframe_left">
            <div class="b-ava-large b-ava-large__nohover">
                <?php if ($user->online): ?>
                    <span class="b-ava-large_online">На сайте</span>
                <?php endif; ?>
                <div class="b-ava-large_ava-hold">
                    <?php $this->widget('Avatar', array(
                        'user' => $user,
                        'size' => Avatar::SIZE_LARGE,
                        'largeAdvanced' => false,
                        'htmlOptions' => array(
                            'class' => 'ava__base-xs',
                        ),
                    )); ?>
                </div>
            </div>
        </div>
        <div class="userSection_left">
            <h2 class="userSection_name userSection-iframe_name"><?=implode(' ', array_filter([Str::ucFirst($user->last_name), Str::ucFirst($user->first_name), Str::ucFirst($user->middle_name)]))?></h2>
            <?php $this->widget('site\frontend\modules\iframe\widgets\answers\AnswerHeaderWidget', [
                'userId' => $user->id,
                'view' => 'stat-profile',
            ]);?>
        </div>
        <div class="userSection-iframe_right">
            <?php if ($specs = $profile->getSpecsString()): ?>
                <div class="userSection-iframe-info">
                    <?php if(!empty($this->user->address->city)) {?>
                        <div class="userSection-iframe-info_opacity"><?=$this->user->address->city->name?></div>
                    <?php } ?>
                    <div class="userSection-iframe-info_orange"><?=$specs?></div>
                </div>
            <?php endif; ?>
            <?php if ($profile->placeOfWork): ?>
                <div class="userSection-iframe-info">
                    <div class="userSection-iframe-info_bold"><?=$profile->placeOfWork?></div>
                </div>
            <?php endif; ?>
            <?php if (count($expCat) > 0): ?>
                <div class="userSection-iframe-info">
                    <div class="userSection-iframe-info_opacity"><?=implode('<br>', $expCat)?></div>
                </div>
            <?php endif; ?>
        </div>

    </div>
</section>
