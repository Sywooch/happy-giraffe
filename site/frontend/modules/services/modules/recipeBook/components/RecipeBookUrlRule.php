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
        if (in_array($route, array('services/recipeBook/default/disease', 'services/recipeBook/default/category')) && isset($params['slug']))
        {
            $url = 'recipeBook/' . $params['slug'];
            unset($params['slug']);

            $url .= $manager->urlSuffix;

            if (!empty($params))
            {
                $url .= '?' . $manager->createPathInfo($params, '=', $ampersand);
            }
            return $url;
        }
        return false;
    }

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
    {
        Yii::import('site.frontend.modules.services.modules.recipeBook.models.*');

        /** @todo Убрать этот блок через месяц после его появления */
        if (preg_match('#^recipeBook\/category\/(\w+)$#', $pathInfo, $matches))
        {
            $slug = $matches[1];
            Yii::app()->request->redirect(Yii::app()->createUrl('services/recipeBook/default/category', array('slug' => $slug)));
        }

        $route = false;

        if (preg_match('#^recipeBook\/(\w+)$#', $pathInfo, $matches))
        {
            $slug = $matches[1];
            if (RecipeBookDisease::model()->exists('slug = :slug', array(':slug' => $slug)))
            {
                $_GET['slug'] = $slug;
                $route = 'services/recipeBook/default/disease';
            }
            elseif (RecipeBookDiseaseCategory::model()->exists('slug = :slug', array(':slug' => $slug)))
            {
                $_GET['slug'] = $slug;
                $route = 'services/recipeBook/default/category';
            }
        }

        /** @todo Убрать этот блок через месяц после его появления */
        if ($route && ($page = $request->getQuery('RecipeBookRecipe_page')))
        {
            unset($_GET['RecipeBookRecipe_page']);
            $_GET['page'] = $page;
            Yii::app()->request->redirect(Yii::app()->createUrl('/' . $route, $_GET));
        }

        return $route;
    }

}

