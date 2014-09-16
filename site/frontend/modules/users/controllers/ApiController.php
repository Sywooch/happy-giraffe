<?php

namespace site\frontend\modules\users\controllers;

/**
 * Description of ApiController
 *
 * @author Кирилл
 */
class ApiController extends \site\frontend\components\api\ApiController
{
    public function actions()
    {
        return \CMap::mergeArray(parent::actions(), array(
                'get' => 'site\frontend\components\api\PackAction',
        ));
    }
    
    public function packGet($id, $avatarSize = false)
    {
        
    }
    
}

?>
