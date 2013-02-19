<?php $this->beginContent('//layouts/main'); ?>
<!-- .header -->
<div class="navigation">
    <?php
    $this->widget('zii.widgets.CMenu', array(
        'linkLabelWrapper' => 'span',
        'items' => array(
            array('label' => 'Имена',
                'url' => array('/club/names/index'),
                'active' => (Yii::app()->controller->uniqueId == 'club/names'),
                'visible' => Yii::app()->user->checkAccess('names')
            ),
            array('label' => 'Маршруты',
                'url' => array('/geo/route/'),
                'active' => (Yii::app()->controller->uniqueId == 'geo/route'),
                'visible' => Yii::app()->user->checkAccess('routes'),
                'items'=>array(
                    array(
                        'label' => 'Маршруты',
                        'url' => array('/geo/route/'),
                        'active' => (Yii::app()->controller->uniqueId == 'geo/routes'),
                    ),
                    array(
                        'label' => 'Регионы',
                        'url' => array('/geo/region/'),
                        'active' => (Yii::app()->controller->uniqueId == 'geo/region'),
                    ),
                    array(
                        'label' => 'Города',
                        'url' => array('/geo/city/'),
                        'active' => (Yii::app()->controller->uniqueId == 'geo/city'),
                    ),
                    array(
                        'label' => 'Цены на топливо',
                        'url' => array('/geo/fuelCost/'),
                        'active' => (Yii::app()->controller->uniqueId == 'geo/fuelCost'),
                    ),
                    array(
                        'label' => 'Склонения городов',
                        'url' => array('/geo/cityDeclension/'),
                        'active' => (Yii::app()->controller->uniqueId == 'geo/cityDeclension'),
                    ),
                ),
            ),
            array('label' => 'Валентинов день',
                'url' => array('/club/valentineSms/'),
                'visible' => Yii::app()->user->checkAccess('valentines_day'),
                'items'=>array(
                    array(
                        'label' => 'Смс',
                        'url' => array('/club/valentineSms/'),
                        'active' => (Yii::app()->controller->uniqueId == 'club/valentineSms'),
                    ),
                ),
            ),
            array('label' => 'Баннеры',
                'url' => array('/club/communityBanners'),
                'active' => (Yii::app()->controller->uniqueId == 'club/communityBanners'),
                'visible' => Yii::app()->user->checkAccess('communityBanners'),
            ),
            array('label' => 'Болезни',
                'url' => array('/club/recipeBookDisease/'),
                'active' => (Yii::app()->controller->uniqueId == 'club/recipeBookDisease' || Yii::app()->controller->uniqueId == 'club/recipeBookDiseaseCategory'),
                'visible' => Yii::app()->user->checkAccess('editRecipeBook'),
                'items' => array(
                    array(
                        'label' => 'Категории',
                        'url' => array('/club/recipeBookDiseaseCategory/'),
                    ),
                )
            ),
            array('label' => 'Спам',
                'active' => (Yii::app()->controller->uniqueId == 'club/reports'),
                'url' => array('/club/reports/spam'),
                'visible' => Yii::app()->user->checkAccess('report'),
                'items' => array(
                    array(
                        'label' => 'Спам',
                        'url' => array('/club/reports/spam'),
                        'visible' => Yii::app()->user->checkAccess('report'),
                    ),
                    array(
                        'label' => 'Жалобы',
                        'url' => array('/club/reports/index'),
                        'visible' => Yii::app()->user->checkAccess('report'),
                    ),
                )

            ),
            array('label' => 'Интересы',
                'active' => (in_array(Yii::app()->controller->uniqueId, array('club/interest', 'club/interestCategory'))),
                'url' => array('/club/interest/'),
                'visible' => Yii::app()->user->checkAccess('interests'),
                'items' => array(
                    array(
                        'label' => 'Категории',
                        'url' => array('/club/interestCategory/'),
                    ),
                )
            ),
            array('label' => 'Гороскоп',
                'active' => (Yii::app()->controller->uniqueId == 'club/horoscope' || Yii::app()->controller->uniqueId == 'club/horoscopeCompatibility' ),
                'url' => array('/club/horoscope/'),
                'visible' => Yii::app()->user->checkAccess('horoscope'),
                'items' => array(
                    array(
                        'label' => 'Гороскоп Совместимости',
                        'url' => array('/club/horoscopeCompatibility/'),
                        'visible' => Yii::app()->user->checkAccess('horoscope'),
                    ),
                ),
            ),
            array('label' => 'Кулинария',
                'active' => (in_array(Yii::app()->controller->uniqueId, array(
                    'cook/cookIngredients',
                    'cook/cookSpices',
                    'cook/cookChooseCategory',
                    'cook/cookChoose',
                    'cook/cookSpicesCategories',
                    'cook/cookDecoration',
                    'cook/cookUnit'
                ))),
                'url' => array('/cook/cookIngredients/'),
                //'visible' => Yii::app()->user->checkAccess('cook_ingredients'),
                'items' => array(
                    array(
                        'label' => 'Ингредиенты',
                        'url' => array('/cook/cookIngredients/'),
                        'visible' => Yii::app()->user->checkAccess('cook_ingredients'),
                    ),
                    array(
                        'label' => 'Меры',
                        'url' => array('/cook/cookUnit/'),
                        'visible' => Yii::app()->user->checkAccess('cook_ingredients'),
                    ),
                    array(
                        'label' => 'Cпеции',
                        'url' => array('/cook/cookSpices/'),
                        'visible' => Yii::app()->user->checkAccess('cook_spices'),
                    ),
                    array(
                        'label' => 'Cпеции категории',
                        'url' => array('/cook/cookSpicesCategories/'),
                        'visible' => Yii::app()->user->checkAccess('cook_spices'),
                    ),
                    array(
                        'label' => 'Как выбрать',
                        'url' => array('/cook/cookChoose/'),
                        'visible' => Yii::app()->user->checkAccess('cook_choose'),
                    ),
                    array(
                        'label' => 'Как выбрать категории',
                        'url' => array('/cook/cookChooseCategory/'),
                        'visible' => Yii::app()->user->checkAccess('cook_choose'),
                    ),
                    array(
                        'label' => 'Украшения блюд',
                        'url' => array('/cook/cookDecoration/'),
                        'visible' => Yii::app()->user->checkAccess('cook_decorations'),
                    ),
                    array(
                        'label' => 'Кухни',
                        'url' => array('/cook/cookCuisine/'),
                        'visible' => Yii::app()->user->checkAccess('cook_choose'),
                    ),
                    array(
                        'label' => 'Сборки',
                        'url' => array('/cook/cookRecipeTag/'),
                        'visible' => Yii::app()->user->checkAccess('cook_choose'),
                    ),
                )
            ),
//            array(
//                'label' => 'Рассылки',
//                'url' => array('/mail/index/index'),
//                'active' => (Yii::app()->controller->uniqueId == 'mail/templates' || Yii::app()->controller->uniqueId == 'mail/index' ),
//                'items' => array(
//                    array(
//                        'label' => 'Создать рассылку',
//                        'url' => array('/mail/index/create'),
//                    ),
//                    array(
//                        'label' => 'Управление шаблонами',
//                        'url' => array('/mail/templates/index'),
//                    )
//                )
//            ),
            array(
                'label' => 'Календари',
                'active' => (in_array(Yii::app()->controller->uniqueId, array('club/calendarBaby', 'club/calendarPregnancy'))),
                'url' => 'javascript:void(0)',
                'visible' => Yii::app()->user->checkAccess('calendar_baby') || Yii::app()->user->checkAccess('calendar_pregnancy'),
                'items' => array(
                    array(
                        'label' => 'Календарь малыша',
                        'url' => array('/club/calendarBaby'),
                        'visible' => Yii::app()->user->checkAccess('calendar_baby'),
                    ),
                    array(
                        'label' => 'Календарь беременности',
                        'url' => array('/club/calendarPregnancy'),
                        'visible' => Yii::app()->user->checkAccess('calendar_pregnancy'),
                    ),
                )
            ),
            array('label' => 'Сервисы',
                'url' => array('/club/services'),
                'active' => (Yii::app()->controller->uniqueId == 'club/services'),
                'visible' => Yii::app()->user->checkAccess('services'),
                'items' => array(
                    array(
                        'label' => 'Сервисы',
                        'url' => array('/club/services'),
                    ),
                    array(
                        'label' => 'Категории сервисов',
                        'url' => array('/club/serviceCategories'),
                    ),
                    array(
                        'label' => 'Линеечки',
                        'url' => array('/club/line'),
                        'visible' => Yii::app()->user->checkAccess('administrator'),
                    ),
                ),
            ),
        ),
    ));?>
    <div class="clear"></div>
    <!-- .clear -->
</div>
<!-- .navigation -->
<div class="content">
    <?php echo $content; ?>
</div>
<!-- .content -->
<?php $this->endContent(); ?>