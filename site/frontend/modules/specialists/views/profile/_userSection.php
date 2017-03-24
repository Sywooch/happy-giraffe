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

// Breadcrumbs
$breadcrumbs = [
    'Главная'       => '/',
    'Мой педиатр'   => \Yii::app()->createUrl('som/qa/default/pediatrician'),
    $user->getFullName()

];

?>

<div class="b-main__inner">
    <div class="b-col__container">
        <div class="b-col b-col--6 b-hidden-md">
            <div class="b-breadcrumbs b-breadcrumbs--theme-default">

            <?php

            $this->widget('zii.widgets.CBreadcrumbs', [
                'links'                => $breadcrumbs,
                'tagName'              => 'ul',
                'htmlOptions'          => [
                    'class' => 'b-breadcrumbs__list'
                ],
                'homeLink'             => FALSE,
                'separator'            => '',
                'activeLinkTemplate'    => '<li class="b-breadcrumbs__item"><a href="{url}" class="b-breadcrumbs__link">{label}</a></li>',
                'inactiveLinkTemplate'  => '<li class="b-breadcrumbs__item">{label}</li>',
            ]);

            ?>

            </div>
        </div>
    </div>
</div>

<section class="user-section user-section--color user-section--padding">
    <div class="user-section__columns user-section__columns--one b-text--center">
        <div class="user-section__ava">

            <a href="javascript:void(0);" class="ava ava--style ava--xl ava--xl-mobile ava--xl_male">
                <img src="<?= $user->getAvatarUrl(Avatar::SIZE_LARGE); ?>" class="ava__img" />
            </a>

        </div>
    </div>
    <div class="user-section__columns user-section__columns--two b-text--left">
        <div class="user-section__title b-text-color--white b-title--bold b-margin--bottom_10">Саша
            <br/>Cпрей Владимировна</div>
        <div class="user-section__special">педиатр, детский хирург</div>
        <div class="user-section__city b-margin--bottom_15">Нижний Новгород</div>
        <div class="user-section__box user-section-box">
            <div class="user-section-box__item user-section-box__item--white">
                <div class="user-section-box__num">1256</div>
                <div class="user-section-box__text">Ответы</div>
            </div>
            <div class="user-section-box__item user-section-box__item--white">
                <div class="user-section-box__num">234</div>
                <div class="user-section-box__static"><span class="user-section-box__roze"></span><span class="user-section-box__roze"></span><span class="user-section-box__roze"></span><span class="user-section-box__senks">Спасибо</span>
                </div>
            </div>
        </div>
    </div>
    <div class="user-section__columns user-section-three user-section__columns--three b-text--center">
        <div class="user-section-three__clinic b-margin--bottom_10">Частная клиника «Альфа-Центр Здоровья»</div>
        <div class="user-section-three__experience">Врач высшей категории стаж более 20 лет</div>
    </div>
</section>

<?php if (0): ?>
<section class="userSection pediator">
    <div class="userSection_hold clearfix">
        <div class="userSection_left">
            <h2 class="userSection_name"><?=implode(' ', array_filter([Str::ucFirst($user->last_name), Str::ucFirst($user->first_name), Str::ucFirst($user->middle_name)]))?></h2>
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
                        'visible' => $profile->specialization ||
                            $profile->careerObject->models ||
                            $profile->educationObject->models ||
                            $profile->coursesObject->models,
                    ],
                ],
            ]);
        ?>
    </div>
</section>
<?php endif; ?>
