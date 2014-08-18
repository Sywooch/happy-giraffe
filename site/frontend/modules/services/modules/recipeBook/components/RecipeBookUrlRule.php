<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 11/08/14
 * Time: 11:46
 */

class RecipeBookUrlRule extends \CBaseUrlRule
{
    public function createUrl($manager, $route, $params, $ampersand)
    {
        if (in_array($route, array('services/recipeBook/default/disease', 'services/recipeBook/default/category')) && isset($params['slug'])) {
            return 'recipeBook/' . $params['slug'];
        }
        return false;
    }

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
    {
        Yii::import('site.frontend.modules.services.modules.recipeBook.models.*');

        if (preg_match('#^recipeBook\/category\/(\w+)$#', $pathInfo, $matches)) {
            $slug = $matches[1];
            Yii::app()->request->redirect(Yii::app()->createUrl('services/recipeBook/default/category', array('slug' => $slug)));
        }

        if (preg_match('#^recipeBook\/(\w+)$#', $pathInfo, $matches)) {
            $slug = $matches[1];
            if (RecipeBookDisease::model()->exists('slug = :slug', array(':slug' => $slug))) {
                $_GET['slug'] = $slug;
                return 'services/recipeBook/default/disease';
            }
            if (RecipeBookDiseaseCategory::model()->exists('slug = :slug', array(':slug' => $slug))) {
                $_GET['slug'] = $slug;
                return 'services/recipeBook/default/category';
            }
        }

        return false;
    }
} 