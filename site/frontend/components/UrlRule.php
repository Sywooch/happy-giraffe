<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UrlRule
 *
 * @author Кирилл
 */
class UrlRule extends CBaseUrlRule
{

    public $pattern;
    public $route;
    public $defaultParams;

    public function createUrl($manager, $route, $params, $ampersand)
    {
        $rule = new CUrlRule($this->route, $this->pattern);
        $rule->defaultParams = $this->defaultParams;
        return $rule->createUrl($manager, $route, $params, $ampersand);
    }

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
    {
        $rule = new CUrlRule($this->route, $this->pattern);
        $rule->defaultParams = $this->defaultParams;
        return $rule->parseUrl($manager, $request, $pathInfo, $rawPathInfo);
    }

}

?>
