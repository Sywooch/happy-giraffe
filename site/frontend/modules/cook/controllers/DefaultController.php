<?php

class DefaultController extends HController
{

    public function actionIndex()
    {
        $this->pageTitle = 'Кулинария';

        $community = Community::model()->findByPk(22);
        $recipes = CookRecipe::model()->lastRecipes;
        $recipesCount = CookRecipe::model()->count();
        $decorations = CookDecoration::model()->lastDecorations;

        $this->render('index', compact('community', 'recipes', 'recipesCount', 'decorations'));
    }

}