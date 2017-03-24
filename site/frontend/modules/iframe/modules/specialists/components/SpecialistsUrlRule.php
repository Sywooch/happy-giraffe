<?php
/**
 * @author Никита
 * @date 30/08/16
 */

namespace site\frontend\modules\iframe\modules\specialists\components;


use site\frontend\modules\iframe\modules\specialists\models\SpecialistProfile;
use site\frontend\modules\users\models\User;

class SpecialistsUrlRule extends \CBaseUrlRule
{
    public function createUrl($manager, $route, $params, $ampersand)
    {
        if ($route == 'iframe/specialists/profile/index') {
            $url = 'user/' . $params['userId'] . $manager->urlSuffix;
            unset($params['userId']);
            if (! empty($params)) {
                $url .= '?' . $manager->createPathInfo($params, '=', $ampersand);
            }
            return $url;
        }
        
        return false;
    }
    
    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
    {
        if (preg_match('#^iframe\/user\/(\d+)$#', $pathInfo, $matches)) {
            $id = $matches[1];
            if (SpecialistProfile::model()->exists('id = :id', [':id' => $id]) && User::model()->active()->exists('id = :id', [':id' => $id])) {
                $_GET['userId'] = $id;
                return 'iframe/specialists/profile/index';
            }
        }
        
        return false;
    }
}