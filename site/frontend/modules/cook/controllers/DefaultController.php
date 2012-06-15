<?php

class DefaultController extends HController
{

    public function actionIndex()
    {
        $this->pageTitle = 'Кулинария';

        $posts = Community::model()->findByPk(22)->getLast(7);
        $recipes = CookRecipe::model()->lastRecipes;
        $recipesCount = CookRecipe::model()->count();
        $decorations = CookDecoration::model()->lastDecorations;

        $this->render('index', compact('posts', 'recipes', 'recipesCount', 'decorations'));
    }

}