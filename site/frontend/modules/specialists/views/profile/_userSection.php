<?php
/**
 * @var User $user
 * @var \site\frontend\modules\specialists\models\SpecialistProfile $profile
 */

$profile = $user->specialistProfile;

$expCat = [];
if ($profile->experience) {
    $expCat[] = 'Стаж: ' . \site\frontend\modules\specialists\models\SpecialistProfile::getCategoriesList()[$profile->experience];
}
if ($profile->category && \site\frontend\modules\specialists\models\SpecialistProfile::getCategoriesList()[$profile->category]) {
    $expCat[] = \site\frontend\modules\specialists\models\SpecialistProfile::getCategoriesList()[$profile->category];
}
?>

<section class="userSection pediator">
    <div class="userSection_hold clearfix">
        <div class="userSection_left">
            <h2 class="userSection_name"><?=$user->getFullName()?></h2>
            <?php if ($profile->placeOfWork): ?>
                <div class="location locationsmall clearfix"><span class="location_tx"><?=$profile->placeOfWork?></span></div>
            <?php endif; ?>
            <?php if ($specs = $profile->getSpecsString()): ?>
                <div class="location locationsmall clearfix margin-t12"><span class="font__title-sn font__semi pediator__color-red"><?=$specs?></span></div>
            <?php endif; ?>
            <?php if (count($expCat) > 0): ?>
                <div class="location locationsmall clearfix"><span class="location_tx"><?=implode(' / ', $expCat)?></span></div>
            <?php endif; ?>
        </div>
        <div class="userSection_center">
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
    </div>
    <div class="userSection_panel">
        <?php
            $this->widget('zii.widgets.CMenu', [
                'htmlOptions' => [
                  'class' => 'userSection_panel-ul clearfix',
                ],
                'itemCssClass' => 'userSection_panel-li',
                'items' => [
                    [
                        'label' => 'Ответы',
                        'url' => ['/specialists/profile/index', 'userId' => $user->id],
                        'linkOptions' => ['class' => 'userSection_panel-a'],
                    ],
                    [
                        'label' => 'Информация',
                        'url' => ['/specialists/profile/info', 'userId' => $user->id],
                        'linkOptions' => ['class' => 'userSection_panel-a'],
                    ],
                ],
            ]);
        ?>
    </div>
</section>
