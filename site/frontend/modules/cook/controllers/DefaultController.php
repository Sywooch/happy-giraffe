<?php

class DefaultController extends HController
{

    public function actionIndex()
    {

        $recipes = CookRecipe::model()->lastRecipes;
        $decorations = CookDecoration::model()->lastDecorations;

        $this->render('index', compact('recipes', 'decorations'));
    }

}