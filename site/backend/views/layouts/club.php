<?php $this->beginContent('//layouts/main'); ?>
<!-- .header -->
<div class="navigation">
    <?php
    $this->widget('zii.widgets.CMenu', array(
        'linkLabelWrapper' => 'span',
        'items' => array(
            array(
                'label' => 'Главная',
                'url' => array('modules/index'),
            ),
            array('label' => 'Имена',
                'url' => array('/club/names/index'),
                'active' => (Yii::app()->controller->id == 'club/names'),
                'visible' => Yii::app()->user->checkAccess('names')
            ),
            array('label' => 'Болезни',
                'url' => array('/club/recipeBookDisease/'),
                'active' => (Yii::app()->controller->id == 'club/recipeBookDisease' || Yii::app()->controller->id == 'club/recipeBookDiseaseCategory'),
                'visible' => Yii::app()->user->checkAccess('editRecipeBook'),
                'items' => array(
                    array(
                        'label' => 'Категории',
                        'url' => array('/club/recipeBookDiseaseCategory/'),
                    ),
                )
            ),
            array('label' => 'Жалобы',
                'active' => (Yii::app()->controller->id == 'club/reports' && Yii::app()->controller->action->id == 'index'),
                'url' => array('/club/reports/index'),
                'visible' => Yii::app()->user->checkAccess('report')
            ),
            array('label' => 'Спам',
                'active' => (Yii::app()->controller->id == 'club/reports' && Yii::app()->controller->action->id == 'spam'),
                'url' => array('/club/reports/spam'),
                'visible' => Yii::app()->user->checkAccess('report')
            ),
            array('label' => 'Интересы',
                'active' => (in_array(Yii::app()->controller->id, array('club/interest', 'club/interestCategory'))),
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
                'active' => (Yii::app()->controller->id == 'club/horoscope'),
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
                'active' => (in_array(Yii::app()->controller->id, array(
                    'club/cookIngredients',
                    'club/cookSpices',
                    'club/cookChooseCategory',
                    'club/cookSpicesCategories',
                    'club/cookDecoration',
                    'club/cookUnit'
                ))),
                'url' => array('/club/cookIngredients/'),
                //'visible' => Yii::app()->user->checkAccess('cook_ingredients'),
                'items' => array(
                    array(
                        'label' => 'Ингредиенты',
                        'url' => array('/club/cookIngredients/'),
                        'visible' => Yii::app()->user->checkAccess('cook_ingredients'),
                    ),
                    array(
                        'label' => 'Меры',
                        'url' => array('/club/cookUnit/'),
                        'visible' => Yii::app()->user->checkAccess('cook_ingredients'),
                    ),
                    array(
                        'label' => 'Cпеции',
                        'url' => array('/club/cookSpices/'),
                        'visible' => Yii::app()->user->checkAccess('cook_spices'),
                    ),
                    array(
                        'label' => 'Cпеции категории',
                        'url' => array('/club/cookSpicesCategories/'),
                        'visible' => Yii::app()->user->checkAccess('cook_spices'),
                    ),
                    array(
                        'label' => 'Как выбрать',
                        'url' => array('/club/cookChoose/'),
                        'visible' => Yii::app()->user->checkAccess('cook_choose'),
                    ),
                    array(
                        'label' => 'Как выбрать категории',
                        'url' => array('/club/cookChooseCategory/'),
                        'visible' => Yii::app()->user->checkAccess('cook_choose'),
                    ),
                    array(
                        'label' => 'Украшения блюд',
                        'url' => array('/club/cookDecoration/'),
                        'visible' => Yii::app()->user->checkAccess('cook_choose'),
                    ),
                )
            ),
            array(
                'label' => 'Рассылки',
                'url' => array('/mail/index/index'),
                'items' => array(
                    array(
                        'label' => 'Создать рассылку',
                        'url' => array('/mail/index/create'),
                    ),
                    array(
                        'label' => 'Управление шаблонами',
                        'url' => array('/mail/templates/index'),
                    )
                )
            )
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