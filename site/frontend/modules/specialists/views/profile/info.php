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

<div class="b-main__inner">
    <div class="b-col__container">
        <div class="block-center b-col--6 b-col-sm--10 b-col-xs">

            <?php

            $this->widget('zii.widgets.CMenu', [
                'htmlOptions'       => [
                    'class' => 'b-filter-menu__panel b-filter-menu__panel--anketa',
                ],
                'itemCssClass'      => 'b-filter-menu__items',
                'activeCssClass'    => 'b-filter-menu__link-anketa--active',
                'items'             => [
                    [
                        'label'         => 'Ответы',
                        'url'           => ['/specialists/profile/index', 'userId' => $this->user->id],
                        'linkOptions'   => [
                            'class' => 'b-filter-menu__link-anketa'
                        ],
                    ],
                    [
                        'label'         => 'Информация',
                        'url'           => ['/specialists/profile/info', 'userId' => $this->user->id],
                        'linkOptions'   => [
                            'class' => 'b-filter-menu__link-anketa'
                        ],
                    ],
                ],
            ]);

            ?>

            <div class="landing-question">
                <div class="user-settings form-edit">
                    <?php if ($profile->specialization): ?>
                        <div class="user-settings_hold"><span class="heading-sm">Специализация</span></div>
                        <div class="user-settings_hold">
                            <div class="form-edit_tx"><?=$profile->specialization?></div>
                        </div>
                    <?php endif; ?>
                    <?php if ($profile->careerObject->models): ?>
                        <div class="user-settings_hold"><span class="heading-sm">Опыт работы</span></div>
                        <?php $this->renderPartial('_infoTable', ['models' => $profile->careerObject->models]); ?>
                    <?php endif; ?>
                    <?php if ($profile->educationObject->models): ?>
                        <div class="user-settings_hold"><span class="heading-sm">Образование</span></div>
                        <?php $this->renderPartial('_infoTable', ['models' => $profile->educationObject->models]); ?>
                    <?php endif; ?>
                    <?php if ($profile->coursesObject->models): ?>
                        <div class="user-settings_hold"><span class="heading-sm">Курсы повышения квалификации</span></div>
                        <?php $this->renderPartial('_infoTable', ['models' => $profile->coursesObject->models]); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>