<?php

class DefaultController extends HController
{

    public function actionIndex()
    {
        $this->pageTitle = 'Кулинария';

        $community = Community::model()->findByPk(22);
        $recipes = SimpleRecipe::model()->lastRecipes;
        $recipesCount = CookRecipe::model()->count('section = 0');
        $decorations = CookDecoration::model()->lastDecorations;
        $chooses = CookChoose::model()->getRandomChooses(3);

        $this->breadcrumbs = array(
            'Кулинария',
        );

        $this->render('index', compact('community', 'recipes', 'recipesCount', 'decorations', 'chooses'));
    }
}