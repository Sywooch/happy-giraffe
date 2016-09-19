<?php
/**
 * @author Никита
 * @date 30/08/16
 */

namespace site\frontend\modules\specialists\components;


use site\frontend\modules\specialists\models\SpecialistProfile;
use site\frontend\modules\users\models\User;

class SpecialistsUrlRule extends \CBaseUrlRule
{
    public function createUrl($manager, $route, $params, $ampersand)
    {
        if ($route == 'specialists/profile/index') {
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
        if (preg_match('#^user\/(\d+)$#', $pathInfo, $matches)) {
            $id = $matches[1];
            if (SpecialistProfile::model()->exists('id = :id', [':id' => $id]) && User::model()->active()->exists('id = :id', [':id' => $id])) {
                $_GET['userId'] = $id;
                return 'specialists/profile/index';
            }
        }
        
        return false;
    }
}