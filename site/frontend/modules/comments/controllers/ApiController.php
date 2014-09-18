<?php

namespace site\frontend\modules\comments\controllers;

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

    public function packGet($id)
    {
        $this->result = array();
    }

    public function actionCreate()
    {
        
    }

    public function actionUpdate()
    {
        
    }

    public function actionRemove()
    {
        
    }

    public function actionRestore()
    {
        
    }

}

?>
