<?php

/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 6/24/13
 * Time: 3:36 PM
 * To change this template use File | Settings | File Templates.
 */
class ConditionalUrlRule extends CBaseUrlRule
{

    public $pattern;
    public $condition;
    public $trueRoute;
    public $falseRoute;

    public function createUrl($manager, $route, $params, $ampersand)
    {
        if ($route !== $this->trueRoute && $route !== $this->falseRoute) {
            return false;
        }
        $urlRuleClass = Yii::import(Yii::app()->urlManager->urlRuleClass, true);
        $rule = new $urlRuleClass($route, $this->pattern);
        return $rule->createUrl($manager, $route, $params, $ampersand);
    }

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
    {
        $urlRuleClass = Yii::import(Yii::app()->urlManager->urlRuleClass, true);
        $rule = new $urlRuleClass($this->getActualRoute(), $this->pattern);
        return $rule->parseUrl($manager, $request, $pathInfo, $rawPathInfo);
    }

    public function getActualRoute()
    {

        return eval('return ' . $this->condition . ';') ? $this->trueRoute : $this->falseRoute;
    }

}