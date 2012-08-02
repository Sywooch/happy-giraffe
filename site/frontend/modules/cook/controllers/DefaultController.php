<?php

class DefaultController extends HController
{

    public function actionIndex()
    {
        $this->pageTitle = 'Кулинария';

        $community = Community::model()->findByPk(22);
        $recipes = SimpleRecipe::model()->lastRecipes;
        $recipesCount = SimpleRecipe::model()->count();
        $decorations = CookDecoration::model()->lastDecorations;
        $chooses = CookChoose::model()->getRandomChooses(3);

        $this->render('index', compact('community', 'recipes', 'recipesCount', 'decorations', 'chooses'));
    }

}