<?php

class DefaultController extends HController
{

    public function actionIndex()
    {
        $this->pageTitle = 'Кулинария';

        //$posts = CommunityContent::model()->lastCookPosts;
        $recipes = CookRecipe::model()->lastRecipes;
        $decorations = CookDecoration::model()->lastDecorations;

        $this->render('index', compact('recipes', 'decorations'));
    }

}