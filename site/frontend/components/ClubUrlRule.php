<?php
/**
 * Class ClubUrlRule
 *
 * Урлы для клубов
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class ClubUrlRule extends CBaseUrlRule
{
    public $pattern;
    public $route;

    public function createUrl($manager, $route, $params, $ampersand)
    {
        $urlRuleClass = Yii::import(Yii::app()->urlManager->urlRuleClass, true);
        $rule = new $urlRuleClass($this->route, $this->pattern);
        return $rule->createUrl($manager, $route, $params, $ampersand);
    }

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
    {
        $slugs = Yii::app()->db->cache(3600)->createCommand()
            ->select('slug')
            ->from('community__clubs')
            ->queryColumn();

        if (in_array($pathInfo, $slugs)) {
            return $this->returnTrue($manager, $request, $pathInfo, $rawPathInfo);
        } else {
            foreach ($slugs as $slug){
                if (str_replace('<club:[\w-]+>', $slug, $this->pattern) == $pathInfo){
                    return $this->returnTrue($manager, $request, $pathInfo, $rawPathInfo);
                }
            }

            return false;
        }
    }

    public function returnTrue($manager, $request, $pathInfo, $rawPathInfo)
    {
        $urlRuleClass = Yii::import(Yii::app()->urlManager->urlRuleClass, true);
        $rule = new $urlRuleClass($this->route, $this->pattern);
        return $rule->parseUrl($manager, $request, $pathInfo, $rawPathInfo);
    }
}